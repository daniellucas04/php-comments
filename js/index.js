const baseURL = 'http://comments.localhost';
function submitOnEnter(event) {
    if(event.key === 'Enter'){
        event.preventDefault();
        document.getElementById("submit").click();
    }
}

function deleteComment(event){
    event.preventDefault();
    fetch(`${baseURL}/actions/delete-comment.php`).then((response) => {
        if (!response.ok) {
            throw Error('Não foi possível concluir a requisição.');
        } else {
            return response.json;
        }
    }).then((data) => {
        console.log(data);
    })
}

let input = document.getElementById("comment");
input.addEventListener("keypress", submitOnEnter);

let deleteCommentButton = document.getElementById("delete-comment");
deleteCommentButton.addEventListener('click', deleteComment);

// let userComment = document.getElementById('user-comment');
// userComment.addEventListener('submit', () => {
//     console.log('oi');
// })