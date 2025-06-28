document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const url = btn.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                btn.querySelector('.like-count').textContent = data.count;
                const icon = btn.querySelector('.heart-icon');
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
            })
            .catch(err => console.error('Like error:', err));
        });
    });
});