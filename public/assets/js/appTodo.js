var appTodo = {
  init: function () {
    console.log('appTodo init');

    // on récupère tous les éléments ayant pour classe .btn-danger (boutons Supprimer)
    var allDeleteBtn = $('.btn-danger');
    //console.log(allDeleteBtn);

    // pour ne pas lire les index spéciaux du tableau, on le parcourt sur la base de son .length ( équivaut seulement aux éléments récupéré ) 
    for (var j = 0; j < allDeleteBtn.length; j++)
    {
        $(allDeleteBtn[j]).on('click', appTodo.handleDeleteTask);
    }
  },

  handleDeleteTask: function (event) {
    console.log('appTodo handleDeleteTask');

    // on récupère l'id du parent de l'élément ciblé
    // autrement dit, on récupère l'id de la tâche à supprimer
    var id = $($(event.target).parent()).data('id');
    console.log(id);

    // var ajaxUrl = "{{ path('delete_task')|e('js') }}";

    var jqxhr = $.ajax({
      url: ajaxUrl, 
      method: 'POST', // méthode HTTP souhaitée pour l'appel Ajax
      dataType: 'json', // type de données attendu en réponse (text, html, xml, json)
      data: {
        id: id
      }
    });
    // on déclare la méthode done, celle-ci sera exécutée si la réponse est satisfaisante
    jqxhr.done(function (response) {
      console.log('handleDeleteTask ajax done');
      window.location.reload();

    });
    // on déclare la méthode fail, celle-ci sera executée si la réponse est insatisfaisante
    jqxhr.fail(function () {
      console.log('handleDeleteTask ajax fail');
      // alert('Requête échouée');
    });
  }
};

$(appTodo.init);