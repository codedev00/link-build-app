<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Exchange Platform</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- main wrapper  -->
    <div class="wrapper">
        <!-- main-header start -->
        <header class="main-header">
            <div class="container">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="#">Link Exchange Platform</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="btn primary-btn-outline" href="{{route('instructions',['shop'=>$store])}}">Instructions</a>
                            </li>
                            <li class="nav-item">
                                <!-- Button trigger modal -->
                                <!-- <button type="button" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" >
                                    Fetch Store Data
                                </button> -->
                                <button type="button" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Fetch Store Data
                                </button>
                                <!-- <li class="nav-item">
                                <a class="btn primary-btn-outline" href="{{route('chart',['shop'=>$store])}}">Dashboard</a>
                            </li> -->
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <!-- header Modal start -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <img src="{{asset('assets/images/popper_img1.png')}} " class="popper-img" />
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">
                            Please Wait ! As it take a while for syncing app
                            with store data
                        </h5>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn primary-btn-outline" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- main header end -->

        <!-- main content start -->
        <main class="main-cotnent">

            <section class="pt-4 pt-xl-5">
                <!-- main tab start -->
                <div class="container">
                    <div class="back-btn mb-4 mb-xl-5">
                        <a class="back-link" href="{{route('index',['shop'=>$store])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                              </svg>
                              <h5 class="mb-0 d-inline-block align-middle heading ms-3">Back to home</h5>
                        </a>
                    </div>

                    <div class="content-wrap cus-card pad-30">
                        <div class="content-block">
                            <h3 class="sub-heading">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquid, error.
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eum nemo cumque aperiam quod neque velit aut cupiditate voluptatibus ipsa. In enim distinctio corporis molestiae dolorem suscipit, earum iure nisi!
                            </p>
                        </div>
                        <div class="content-block">
                            <h3 class="sub-heading">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquid, error.
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eum nemo cumque aperiam quod neque velit aut cupiditate voluptatibus ipsa. In enim distinctio corporis molestiae dolorem suscipit, earum iure nisi!
                            </p>
                        </div>
                        <div class="content-block">
                            <h3 class="sub-heading">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquid, error.
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eum nemo cumque aperiam quod neque velit aut cupiditate voluptatibus ipsa. In enim distinctio corporis molestiae dolorem suscipit, earum iure nisi!
                            </p>
                        </div>
                        <div class="content-block">
                            <h3 class="sub-heading">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquid, error.
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eum nemo cumque aperiam quod neque velit aut cupiditate voluptatibus ipsa. In enim distinctio corporis molestiae dolorem suscipit, earum iure nisi!
                            </p>
                        </div>
                        <div class="content-block">
                            <h3 class="sub-heading">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquid, error.
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eum nemo cumque aperiam quod neque velit aut cupiditate voluptatibus ipsa. In enim distinctio corporis molestiae dolorem suscipit, earum iure nisi!
                            </p>
                        </div>
                        <div class="content-block">
                            <h3 class="sub-heading">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquid, error.
                            </h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis eum nemo cumque aperiam quod neque velit aut cupiditate voluptatibus ipsa. In enim distinctio corporis molestiae dolorem suscipit, earum iure nisi!
                            </p>
                        </div>
                    </div>
                </div>
                <!-- manin tab end -->
            </section>
        </main>
        <!-- main content end -->
    </div>
    <!-- main wrapper end -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--popper.min.js  -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
        crossorigin="anonymous"></script>
    <!-- bootstrap min.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.js"></script>
    <script>
        $(document).ready(function () {
            $(".js-select2").select2({
                dropdownCssClass: "big-drop",
                placeholder: "Please select a Page"
            });
        });
    </script>
</body>

</html>