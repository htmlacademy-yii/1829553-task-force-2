$(document).ready(function()
{
  const lat = $('#lat');
  const long = $('#long');

  const autoCompleteJS = new autoComplete(
    {
      placeHolder: "Поиск ...",
      data: {
        src: async (query) => {
          try {
            // Fetch Data from external Source
            const source = await fetch(url_get_geo + '/' + query);
            // Data is array of `Objects` | `Strings`
            const data = await source.json();

            return data;
          } catch (error) {
            return error;
          }
        },
        // Data 'Object' key to be searched
        keys: ["full_address"]
      },
      resultsList: {
        element: (list, data) => {
          if (!data.results.length) {
            const message = document.createElement("div");
            message.setAttribute("class", "no_result");
            message.innerHTML = `<span>Нет данных "${data.query}"</span>`;
            list.prepend(message);
          }
        },
        noResults: true,
      },
      resultItem: {
        highlight: {
          render: true
        }
      },
      events: {
        input: {
          selection: (event) => {
            const selection = event.detail.selection.value;
            autoCompleteJS.input.value = selection.full_address;

            lat.val(selection.lat);
            long.val(selection.long)
          }
        }
      }
    }
  );
});
