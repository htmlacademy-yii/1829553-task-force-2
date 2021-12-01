<?php

namespace app\models;

use Mar4hk0\Exceptions\ExceptionFile;
use Mar4hk0\Exceptions\ExceptionTask;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\web\UploadedFile;

class TaskForm extends Model
{
    public string $title = '';
    public string $description = '';
    public int $categoryId = 1;
    public string $address = '';
    public int $price = 0;
    public string $deadline = '';
    public array $filesSource = [];

    private Task $task;
    private array $files;

    public function rules()
    {
        return [
            [['title', 'description', 'categoryId'], 'required'],
            ['title', 'string', 'min' => 10],
            ['description', 'string', 'min' => 30],
            [['categoryId'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['categoryId' => 'id']],
            ['price', 'integer', 'min' => 1],
            [['deadline', 'address', 'files'], 'safe'],
//            ['deadline ', 'datetime', 'format' => 'php:m/d/Y']
        ];
    }

    public function process(): bool
    {
        if ($this->validate()) {

            $transaction = Task::getDb()->beginTransaction();
            try {
                /* @var $user User */
                $user = Yii::$app->params['user'];
                $task = new Task();
                $attr = [
                    'title' => $this->title,
                    'description' => $this->description,
                    'city_id' => $user->city_id,
                    'price' => $this->price,
                    'category_id' => $this->categoryId,
                    'client_id' => $user->id,
                    'deadline' => $this->deadline,
                    'address' => $this->address,
                    'long' => '',
                    'lat' => '',
                    'status_id' => Status::getStatusNewId(),
                    'created' => date('Y-m-d H:i:s'),
                ];
                $task->attributes = $attr;
                if (!$task->save()) {
                    throw new ExceptionTask('Something goes wrong. Can not save Task.');
                }

                $this->task = $task;

                foreach ($this->filesSource as $item) {
                    /* @var $item UploadedFile*/
                    $fileName = $this->generateFileName($item);
                    $filePath = Yii::getAlias('@files');
                    if (!$item->saveAs($filePath . '/' . $fileName)) {
                        throw new ExceptionFile('Something goes wrong. Can not save file: ' . $fileName);
                    }

                    $file = new File();
                    $attr = [
                        'name' => $fileName,
                        'path' => $filePath,
                        'client_id' => $user->id,
                        'task_id' => $task->id,
                        'created' => date('Y-m-d H:i:s'),
                    ];
                    $file->attributes = $attr;
                    if (!$file->save()) {
                        throw new ExceptionFile('Something goes wrong. Can not save file: ' . $fileName . ' in DB');
                    }
                    $this->files[] = $file;
                }

                $transaction->commit();
            } catch(\Throwable $exception) {
                $transaction->rollBack();
                throw $exception;
            }
            return true;
        }

        return false;
    }

    private function generateFileName(UploadedFile $file): string
    {
        $fileName = $file->baseName . '.' . $file->extension;
        $filePath = Yii::getAlias('@files');
        if (file_exists($filePath . '/' . $fileName)) {
            $fileName = $file->baseName . '_' . date('Y_m_d_H_i_s') . '.' . $file->extension;
        }
        return $fileName;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function getFiles(): array
    {
        return $this->files;
    }


}
