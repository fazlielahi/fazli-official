$(document).ready(function () {
    $(document).on('click', '.read-comments-btn', function (e) {
        e.preventDefault();
        const blogId = $(this).data('blog-id');

        $('#show-comments-' + blogId).stop(true, true).slideDown('slow');
        $(this).closest('.read-comments-wrapper').fadeOut('fast');
    });

    $(document).on('hidden.bs.modal', '.comment-modal', function () {
        const modal = $(this);
        const blogIdMatch = modal.attr('id').match(/editModal(\d+)/);
        if (!blogIdMatch) {
            return;
        }

        const blogId = blogIdMatch[1];

        if (modal.find('.comment-modal__body').length) {
            const body = modal.find('.comment-modal__body');
            if (body.length) {
                body.scrollTop(0);
            }
            return;
        }

        $('#show-comments-' + blogId).hide();
        modal.find('.read-comments-wrapper').fadeIn('fast');
    });

    $(document).on('shown.bs.modal', '.comment-modal', function () {
        const modal = $(this);
        const blogIdMatch = modal.attr('id').match(/editModal(\d+)/);
        if (!blogIdMatch) {
            return;
        }

        const blogId = blogIdMatch[1];

        if (modal.find('.comment-modal__body').length) {
            return;
        }

        $('#show-comments-' + blogId).hide();
        modal.find('.read-comments-wrapper').show();
    });
});

document.addEventListener('DOMContentLoaded', function () {
    function updateCommentCount(blogId) {
        const countEl = document.getElementById('comment-count-' + blogId);
        const list = document.getElementById('show-comments-' + blogId);
        if (!countEl || !list) {
            return;
        }

        const total = list.querySelectorAll('.comment-card').length;
        const labels = window.TFC_BLOG_COMMENTS || {};
        let text = '';

        if (total === 0) {
            text = labels.noCommentsLabel || 'No comments yet';
        } else if (total === 1) {
            text = '1 ' + (labels.commentLabel || 'Comment');
        } else {
            text = total + ' ' + (labels.commentsLabel || 'Comments');
        }

        countEl.textContent = text;
        countEl.dataset.count = String(total);
    }

    function handleCommentSubmission(form) {
        const blogId = form.id.replace('comment-form-', '');
        const url = form.action;
        const formData = new FormData(form);
        const errorDiv = form.querySelector('.ajax-comment-error');
        if (errorDiv) {
            errorDiv.textContent = '';
        }

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        })
            .then(async function (res) {
                if (!res.ok) {
                    const data = await res.json();
                    if (data.errors && data.errors.comment) {
                        errorDiv.textContent = data.errors.comment[0];
                    } else {
                        errorDiv.textContent = 'An error occurred.';
                    }
                    throw new Error('Validation error');
                }
                return res.json();
            })
            .then(function (data) {
                const commentsList = document.getElementById('show-comments-' + blogId);
                if (commentsList) {
                    const noComments = commentsList.querySelector('.no-comments, .comment-modal__empty');
                    if (noComments) {
                        noComments.remove();
                    }
                    commentsList.insertAdjacentHTML('afterbegin', data.html);
                }

                updateCommentCount(blogId);

                const textarea = form.querySelector('textarea');
                if (textarea) {
                    textarea.value = '';
                }
            })
            .catch(function (err) {
                if (err.message !== 'Validation error') {
                    console.error('Comment submission error:', err);
                }
            });
    }

    document.addEventListener('submit', function (e) {
        const form = e.target.closest('.ajax-comment-form');
        if (!form) {
            return;
        }
        e.preventDefault();
        handleCommentSubmission(form);
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.comment-btn-inside');
        if (!btn) {
            return;
        }
        const form = btn.closest('.ajax-comment-form');
        if (!form) {
            return;
        }
        e.preventDefault();
        handleCommentSubmission(form);
    });
});
