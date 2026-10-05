@extends('layouts.main')

@section('content')

<!-- breadcrumb section start -->
@include('partials.breadcrumb', ['pageTitle' => 'blog'])

<!-- blog section start -->
<div class="ff_blog_single_wrapper top_padder80 bottom_padder30">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">

                  @include('partials.blog-sidebar')

            </div>
            <div class="col-lg-8 col-md-12">
                <div class="ff_blog_all_items">
                    <div class="ff_blog_item">
                        <div class="ff_blog_single_img">
                            <img src="assets/images/blog_single/blog_single.jpg" alt="blog single" title="Blog Single" class="img-fluid">
                            <p><a href="blog_single.html">19-11-2017</a></p>
                        </div>
                        <div class="ff_blog_single_text">
                            <h4>How Do Cardio Works</h4>
                            <ul>
                                <li><i class="fa fa-heart" aria-hidden="true"></i>360</li>
                                <li><i class="fa fa-comment" aria-hidden="true"></i>26</li>
                                <li><i class="fa fa-share-alt" aria-hidden="true"></i>Share
                                    <ul class="ff_share">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                </li>
                            </ul>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
                            <blockquote><i class="fa fa-quote-left" aria-hidden="true"></i>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laborios-am, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.  Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur.<i class="fa fa-quote-right" aria-hidden="true"></i></blockquote>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur</p>
                            <div class="ff_tags">
                                <p><i class="fa fa-tags"></i>Tags - Fitness, Cardio, Bodybuilding</p>
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="ff_comments">
                        <h2>Commetns</h2>
                        <ul class="comment-list">
                            <li>
                                <div class="ff_comment_box">
                                    <div class="ff_comment_img">
                                        <img src="assets/images/blog_single/comment.jpg" alt="comment" title="Comment" class="img-fluid">
                                    </div>
                                    <div class="ff_comment_text">
                                        <h4><a href="#">James Falkner</a></h4>
                                        <h5>1 March 2017 | 08:31am<a href="#"><i class="fa fa-reply"></i>Reply</a></h5>
                                        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="ff_comment_box">
                                    <div class="ff_comment_img">
                                        <img src="assets/images/blog_single/comment.jpg" alt="comment" title="Comment" class="img-fluid">
                                    </div>
                                    <div class="ff_comment_text">
                                        <h4><a href="#">James Falkner</a></h4>
                                        <h5>1 March 2017 | 08:31am<a href="#"><i class="fa fa-reply"></i>Reply</a></h5>
                                        <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="ff_comment_form">
                        <h2>Post a Comment</h2>
                        <form>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="ff_comment_input">
                                        <input type="text" placeholder="Name..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="ff_comment_input">
                                        <input type="text" placeholder="Email..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="ff_comment_input">
                                        <textarea placeholder="Comment" class="form-control"></textarea>
                                        <a href="#" class="ff_button">Submit</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection