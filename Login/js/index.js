var working = false;
$('.login').on('submit', function(e) {
  e.preventDefault();
  if (working) return;
  working = true;
  var $this = $(this),
    $state = $this.find('button > .state');
  $this.addClass('loading');
  $state.html('Cargando');
  setTimeout(function() {
    $this.addClass('ok');
    $state.html('Bienvenido');
    window.open('../../Intranet/index.html', '_self', 'no', false);
    setTimeout(function() {
      $state.html('Acceder');
      $this.removeClass('ok loading');
      working = false;
    }, 4000);
  }, 3000);
});
