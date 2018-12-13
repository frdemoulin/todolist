var app = {
  init: function () {
    console.log('app init');

    // ajout de la getion de l'event click sur le bouton d'ajout de liste
    document.getElementById('btn-delete').addEventListener('click', app.handleDeleteSubmit);
  },

  handleDeleteSubmit: function () {
    console.log('app handleDeleteSubmit');
    var jqxhr = $.ajax({
      url: 'http://localhost'+ app.uriBack +'/tags/'+ app.idTag + '/quiz', 
      method: 'POST', // méthode HTTP souhaitée pour l'appel Ajax (GET ou POST)
      dataType: 'json', // type de données attendu en réponse (text, html, xml, json)
      data: {
        email: emailUser,
        uri: app.uri
      }
    });
    // on déclare la méthode done, celle-ci sera exécutée si la réponse est satisfaisante
    jqxhr.done(function (response) {
      for ( var index in response) {
        if(index === '0') 
        {
          $('.tag h2').html('Liste des quiz du sujet '+ response[index] +'.');
        }
        else {
          var divQuizz = app.constructQuiz(response[index]);
          $(divQuizz).appendTo('.lists');
        }
      }
    });
    // on déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      alert('Requête échouée');
    });
  }
};

$(app.init);