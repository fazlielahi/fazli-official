$(document).ready(function () {
    $('.read-comments-btn').on('click', function (e) {
        e.preventDefault();
        const blogId = $(this).data('blog-id');

        $('#show-comments-' + blogId).stop(true, true).slideDown('slow');
        $(this).closest('.read-comments-wrapper').fadeOut('fast');
    });

    // Reset when modal is hidden
    $('.modal').on('hidden.bs.modal', function () {
        const modal = $(this);

        // Find blog ID from modal ID (editModal{id})
        const blogIdMatch = modal.attr('id').match(/editModal(\d+)/);
        if (blogIdMatch) {
            const blogId = blogIdMatch[1];

            $('#show-comments-' + blogId).hide(); // Hide comments
            modal.find('.read-comments-wrapper').fadeIn('fast'); // Restore the button
        }
    });

    // Ensure comments are hidden when modal is shown
    $('.modal').on('shown.bs.modal', function () {
        const modal = $(this);

        // Find blog ID from modal ID (editModal{id})
        const blogIdMatch = modal.attr('id').match(/editModal(\d+)/);
        if (blogIdMatch) {
            const blogId = blogIdMatch[1];

            // Ensure comments are hidden
            $('#show-comments-' + blogId).hide();
            modal.find('.read-comments-wrapper').show();
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Handle both regular submit buttons and buttons inside textarea
    document.querySelectorAll('.ajax-comment-form').forEach(function(form) {
        // Handle form submit event
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            handleCommentSubmission(this);
        });
        
        // Handle button clicks inside textarea
        const commentBtnInside = form.querySelector('.comment-btn-inside');
        if (commentBtnInside) {
            console.log('Found comment button inside:', commentBtnInside);
            commentBtnInside.addEventListener('click', function(e) {
                console.log('Comment button clicked');
                e.preventDefault();
                handleCommentSubmission(form);
            });
        }
    });
    
    function handleCommentSubmission(form) {
        console.log('handleCommentSubmission called with form:', form);
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
        .then(async res => {
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
        .then(data => {
            // Prepend the new comment to the list
            const commentsList = document.getElementById('show-comments-' + blogId);
            if (commentsList) {
                // Remove 'no-comments' message if present
                const noComments = commentsList.querySelector('.no-comments');
                if (noComments) noComments.remove();
                commentsList.insertAdjacentHTML('afterbegin', data.html);
                
                // Show the comments list since we now have comments
                commentsList.style.display = 'block';
            }
            
            // Update modal footer - remove "Be the first to comment!" and add "Read all comments" button
            const modal = document.getElementById('editModal' + blogId);
            if (modal) {
                const commentFormSection = modal.querySelector('.d-flex.justify-content-between');
                if (commentFormSection) {
                    const firstCommentSpan = commentFormSection.querySelector('.text-light');
                    if (firstCommentSpan && firstCommentSpan.textContent.includes('Be the first to comment')) {
                        firstCommentSpan.remove();
                        const readCommentsWrapper = document.createElement('div');
                        readCommentsWrapper.className = 'read-comments-wrapper';
                        readCommentsWrapper.innerHTML = `
                            <a class="read-comments-btn" href="#show-comments-${blogId}" data-blog-id="${blogId}" style="color: #FFC224;">
                                Read all comments <i class="fa-solid fa-arrow-down-wide-short" style="color: #FFC224;"></i>
                            </a>
                        `;
                        commentFormSection.insertBefore(readCommentsWrapper, commentFormSection.querySelector('button'));
                        
                        // Add event listener to the new button
                        const newReadBtn = readCommentsWrapper.querySelector('.read-comments-btn');
                        if (newReadBtn) {
                            newReadBtn.addEventListener('click', function(e) {
                                e.preventDefault();
                                const blogId = this.getAttribute('data-blog-id');
                                const commentsList = document.getElementById('show-comments-' + blogId);
                                
                                if (commentsList) {
                                    commentsList.style.display = 'block';
                                    this.closest('.read-comments-wrapper').style.display = 'none';
                                }
                            });
                        }
                    }
                }
            }
            
            // Clear textarea
            const textarea = form.querySelector('textarea[name="comment"]');
            if (textarea) {
                textarea.value = '';
            }

            // Show success message
            const msg = document.getElementById('comment-success-message');
            if (msg) {
                msg.style.display = 'block';
                setTimeout(() => { msg.style.display = 'none'; }, 2000);
            }
        })
        .catch(err => {
            // Already handled above
        });
    }
});