<div class="row">
<div class="col-5 col-md-5">
<div class="post-date mb-0"><i class="bi bi-clock"></i><span class="fw-light">{$news.date_add|date_format:"%d/%m/%Y"}</span></div>
</div>
<div class="col-7 col-md-7">
    <ul class="social-share d-flex m-0">
        <li class="me-2 category mt-1">Share</li>
        <li class="pr-1"><a href="https://www.facebook.com/sharer.php?u={$current_url}&caption={$news.title|stripslashes}" aria-label="Chia sẻ bài viết lên facebook" target="_blank" class="text-primary"><i class="fa bi-facebook"></i></a></li>
        <li><a href="https://twitter.com/intent/tweet?url={$current_url}&text={$news.title|stripslashes}" aria-label="Chia sẻ bài viết lên twitter" target="_blank"><i class="fa bi-twitter"></i></a></li>
        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={$current_url}" aria-label="Chia sẻ bài viết lên linked" target="_blank"><i class="fa bi-linkedin"></i></a></li>
        <li>
            <div class="zalo-share-button"  data-oaid="1069300263628412773" data-layout="2" data-color="blue" data-customize="false"></div>
        </li>
    </ul>
</div>
</div>