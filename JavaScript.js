let page = 1;
let loading = false;
let end = false;

window.addEventListener('scroll', function () {
    if (loading || end) return;

    let scrollPosition = window.scrollY + window.innerHeight;
    let documentHeight = document.documentElement.scrollHeight;

    if (scrollPosition >= documentHeight - 100) {
        loadMorePosts();
    }
})

function loadMorePosts() {
    loading = true;
    page++;

    fetch('posts/load_post.php?page=' + page)
        .then(response => response.text())
        .then(data => {
            if (data.trim() === '') {
                end = true;
            } else {
                document.getElementById('posts-container').innerHTML += data;
                loading = false;
            }
        });
}