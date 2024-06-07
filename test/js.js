document.addEventListener("DOMContentLoaded", function () {
  uploadfiles();
  sendform();
});

function uploadfiles() {
  let form = document.querySelector("[data-form]");
  form.addEventListener("change", function (event) {
    event.preventDefault();
    let formData = new FormData(form);
    console.log(formData);
    BX.ajax({
      url: "/../test/sendfile.php",
      data: formData,
      method: "POST",
      dataType: "json",
      processData: true,
      preparePost: false,
      onsuccess: function (data) {
        var showMsgDiv = document.querySelector("[data-show-msg]");

        // Если data.multi равно false, удаляем все элементы <p> и <input>
        if (!data.multi) {
          showMsgDiv.textContent = data.message;
          var inputElement = document.createElement("input");
          inputElement.type = "hidden";
          inputElement.name = "loaded_file";
          inputElement.value = data.id;
          showMsgDiv.appendChild(inputElement);
        } else {
          var pElement = document.createElement("p");
          pElement.textContent = data.message;
          showMsgDiv.appendChild(pElement);

          var inputElement = document.createElement("input");
          inputElement.type = "hidden";
          inputElement.name = "loaded_file[]";
          inputElement.value = data.id;
          showMsgDiv.appendChild(inputElement);
        }
      },
      onfailure: function (data) {
        console.error(data);
      },
    });
  });
}
function sendform() {
  let form = document.querySelector("[data-form]");
  form.addEventListener("submit", function (event) {
    event.preventDefault();
    let formData = new FormData(form);
    console.log(formData);
    BX.ajax({
      url: "/../test/sendform.php",
      data: formData,
      method: "POST",
      dataType: "json",
      processData: true,
      preparePost: false,
      onsuccess: function (data) {},
      onfailure: function (data) {
        console.error(data);
      },
    });
  });
}
