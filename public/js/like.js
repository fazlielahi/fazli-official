document.addEventListener('click', function (e) {
    const btn = e.target.closest('.like-btn');
    if (!btn) {
        return;
    }

    e.preventDefault();

    const url = btn.dataset.url;
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
    })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            const countEl = btn.querySelector('.like-count');
            if (countEl) {
                countEl.textContent = data.count;
            }
            const icon = btn.querySelector('.heart-icon');
            if (icon) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            }
        })
        .catch(function (err) { console.error('Like error:', err); });
});
