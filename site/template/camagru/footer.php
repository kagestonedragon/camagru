    </main>
    <footer>
        <div class="nav-footer">
            <a href="https://github.com/kagestonedragon/" target="_blank"><img src="/markups/images/github.png"></a>
        </div>
    </footer>
    <div class="posts__item-new">
        <a href="/items/add/"><i class="fas fa-plus"></i></a>
    </div>
    <script src="/markups/js/event_listeners.js"></script>
    <script>
        const updateLikesEvents = function(){
          const updateLike = function(e, show, hide) {
              e.preventDefault();
              show.style.display = '';
              hide.style.display = 'none';

              const request = new XMLHttpRequest();
              request.open('GET', hide.href);
              request.send();
          };

          const likes = document.getElementsByClassName('js-likes');
          for (let i = 0; i < likes.length; i++) {
              const likeAmount = likes[i].getElementsByClassName('js-likes-amount')[0];
              const likeAdd = likes[i].getElementsByClassName('js-likes-add')[0];
              const likeDelete = likes[i].getElementsByClassName('js-likes-delete')[0];

              likeAdd.addEventListener('click', function(e){
                  updateLike(e, likeDelete, likeAdd);
                  likeAmount.innerHTML = parseInt(likeAmount.innerHTML) + 1;
              });
              likeDelete.addEventListener('click', function(e){
                  updateLike(e, likeAdd, likeDelete);
                  likeAmount.innerHTML = parseInt(likeAmount.innerHTML) - 1;
              });
          }
        };

        const updateCommentsDelete = function(){
            const deleteComment = function(e, commentLink, comment) {
                e.preventDefault();

                if (comment.parentNode) {
                    comment.parentNode.removeChild(comment);
                    const request = new XMLHttpRequest();
                    request.open('GET', commentLink.href);
                    request.send();
                }
            };

            const comments = document.getElementsByClassName('js-comment');
            for (let i = 0; i < comments.length; i++) {
                const comment = comments[i].getElementsByClassName('js-comment-delete')[0];

                if (comment) {
                    comment.addEventListener('click', function(e) {
                        deleteComment(e, comment, comments[i]);
                    });
                }
            }
        };

        const updateAddCommentButtons = function () {
            const newComment = document.getElementsByClassName('js-new-comment');
            for (let i = 0; i < newComment.length; i++) {
                const button = newComment[i].getElementsByClassName('js-new-comment-button')[0];
                const submit = newComment[i].getElementsByClassName('js-new-comment-submit')[0];

                button.addEventListener('click', function(e) {
                    submit.click();
                });
            }
        };

        const updateAddComment = function() {
            const newComment = document.getElementsByClassName('js-new-comment');

            for (let i = 0; i < newComment.length; i++) {
                const submit = newComment[i].getElementsByClassName('js-new-comment-submit')[0];
                const url = newComment[i].getElementsByClassName('js-new-comment-form')[0].action;
                const text = newComment[i].getElementsByClassName('js-new-comment-text')[0];
                const newCommentTemplate = document.getElementsByClassName('js-comment-template')[0];
                const comments = newComment[i].previousElementSibling;

                submit.addEventListener('click', function(e) {
                    e.preventDefault();

                    const request = new XMLHttpRequest();
                    request.responseType = 'text';
                    request.open('POST', url, true);
                    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    request.send("commentary=" + text.value);
                    request.addEventListener("readystatechange", () => {
                        if(request.readyState === 4 && request.status === 200) {
                            response = JSON.parse(request.responseText);
                            const newCommentClone = newCommentTemplate.cloneNode(true);
                            newCommentClone.style.display = '';
                            newCommentClone.getElementsByClassName('posts__comments__item-text')[0].innerHTML = text.value;
                            newCommentClone.classList.remove('js-comment-template');
                            newCommentClone.classList.add('js-comment');
                            newCommentClone.getElementsByClassName('posts__comments__item-delete')[0].href = '/items/' + response['item_id'] + '/commentary/' + response['id'] + '/delete/';
                            comments.append(newCommentClone);
                            text.value = '';
                            updateCommentsDelete();
                        }
                    });
                });
            }
        };

        updateLikesEvents();
        updateCommentsDelete();
        updateAddCommentButtons();
        updateAddComment();
    </script>
</body>
</html>