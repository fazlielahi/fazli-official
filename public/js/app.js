  (function(){
    const loader = document.getElementById('page-loader');

    function showLoader() {
      loader.classList.add('active');
    }
    document.addEventListener('click', e => {
      const a = e.target.closest('a[href]');
      if (a && a.target !== '_blank' && !a.href.startsWith('javascript:')) {
        showLoader();
      }
    });
    document.addEventListener('submit', e => {
      showLoader();
    });

    window.addEventListener('load', () => {
      loader.classList.remove('active');
    });
  })();
