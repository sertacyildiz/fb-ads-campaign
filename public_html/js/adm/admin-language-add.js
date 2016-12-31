$(function(){

  var createButton = document.getElementById('btnaddlang');
  var url = "/administration/languages/create";
  var tbody = document.getElementById('languagetablebody');
  var langObject;


  var generateHtml = function(){

    $.ajax( {
      dataType: 'json',
      url: url,
      type: 'post',
      data: {create : true},
      context: document.body,
      error: function ( xhr, textStatus, errorThrown ) {
        console.log( textStatus, errorThrown );
      },
      success: function ( data, textStatus, xhr ) {
        langObject = data;


        var tr = document.createElement('tr');
        tr.className = "deletable";

        var td1 = document.createElement('td');
        var orderInput = document.createElement('input');
        orderInput.type = "text";
        orderInput.name = "order";
        orderInput.value = langObject.order;
        orderInput.setAttribute('data-id', data._id);
        orderInput.className = "form-control line jsonupdate";
        orderInput.setAttribute('data-url', '/administration/languages/json');
        td1.appendChild(orderInput);

        tr.appendChild(td1);

        var td2 = document.createElement('td');
        var nameInput = document.createElement('input');
        nameInput.type = "text";
        nameInput.name = "name";
        nameInput.value = langObject.name;
        nameInput.setAttribute('data-id', data._id);
        nameInput.className = "form-control line jsonupdate";
        nameInput.setAttribute('data-url', '/administration/languages/json');
        td2.appendChild(nameInput);

        tr.appendChild(td2);

        var td3 = document.createElement('td');
        var codeInput = document.createElement('input');
        codeInput.type = "text";
        codeInput.name = "code";
        codeInput.value = langObject.code;
        codeInput.setAttribute('data-id', data._id);
        codeInput.className = "form-control line jsonupdate";
        codeInput.setAttribute('data-url', '/administration/languages/json');
        td3.appendChild(codeInput);

        tr.appendChild(td3);

        var td4 = document.createElement('td');
        var buttonGroup = document.createElement('div');
        buttonGroup.className = "btn-group btn-group-sm";

        var activator = document.createElement('button');
        activator.className = "btn btn-default activator btn-sm activebutton";
        activator.setAttribute('data-url' , '/administration/languages/json');
        activator.setAttribute('data-id', langObject._id);

        var eyeIcon = document.createElement('i');
        eyeIcon.className = "fa fa-eye-slash";

        activator.appendChild(eyeIcon);
        buttonGroup.appendChild(activator);

        var deleter = document.createElement('button');
        deleter.className = "deleter btn btn-danger";
        deleter.setAttribute('data-url' , '/administration/languages/json');
        deleter.setAttribute('data-id', langObject._id);

        var deleteIcon = document.createElement('i');
        deleteIcon.className = "fa fa-times";

        deleter.appendChild(deleteIcon);
        buttonGroup.appendChild(deleter);

        td4.appendChild(buttonGroup);

        tr.appendChild(td4);


        tbody.insertBefore(tr,tbody.firstChild);

      }

    });

  };

  createButton.addEventListener('click', generateHtml);
});