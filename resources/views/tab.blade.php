
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
    <!-- <link rel="stylesheet" href="{{asset('css/style.css')}}">   -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
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
                                
                                <!-- <a href="{{route('product',['shop'=>$store])}}"> <button type="button" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Fetch Store Data
                                </button></a> -->
                                <!-- <a href="{{route('blogs',['shop'=>$store])}}"> <button type="button" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Fetch Store Data
                                </button></a> -->
                                <!-- <a href="{{route('pages',['shop'=>$store])}}"> <button type="button" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Fetch Store Data
                                </button></a> -->
                                <button type="button" class="btn primary-btn" data-bs-toggle="modal"
                                    data-bs-target="#Modal">
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
        <!-- header modal end -->
        <!-- main header end -->

        <!-- main content start -->
        <main class="main-cotnent">

            <section class="pt-4 pt-xl-5">
                <!-- main tab start -->
                <div class="container">
                    <div class="tab-wrap cus-card">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-dashboard" type="button" role="tab" aria-controls="pills-dashboard"
                                    aria-selected="true">Dashboard</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="pills-search-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-search" type="button" role="tab" aria-controls="pills-search"
                                    aria-selected="true">Enable Links</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-inbound-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-inbound" type="button" role="tab"
                                    aria-controls="pills-inbound" aria-selected="false">Inbound links</button>
                            </li>
                            <li class="nav-item" role="presentation" style="display:none;">
                                <button class="nav-link " id="pills-outbound-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-outbound" type="button" role="tab"
                                    aria-controls="pills-outbound" aria-selected="false">Outbound Links</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-settings" type="button" role="tab"
                                    aria-controls="pills-settings" aria-selected="false">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link " id="pills-plans-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-plans" type="button" role="tab"
                                    aria-controls="pills-plans" aria-selected="false">Plans</button>
                            </li>
                        </ul>
                       
                        <div class="tab-content" id="pills-tabContent">
                              <!-- dashboard tab start -->
                            <div class="tab-pane fade active show dashshow" id="pills-dashboard" role="tabpanel"
                                aria-labelledby="pills-dashboard-tab" tabindex="0">
                                <div class="tab-content-wrap ">
                                    <div class="container px-4 mx-auto">
                                    <div class="p-6 m-20 bg-white rounded shadow"> 
                                        @if(isset($incount))
                                
                                    <b style="font-size:20px;"><u>Your Statistic Overview</u></b>
                                    <div class="cus-card stat-card p-3 p-md-4 mt-4">
                                        <div class="row">
                                            <div class="col-md-3 stat-col">
                                            <div class="hstack gap-3 stat-items">
                                                <div class="stat-icon icon-danger">
                                                <i class="fa-solid fa-chart-line"></i>
                                                </div>
                                                <div class="stack-content">
                                                    @if(isset($score))
                                                <h4 class=" text-mute fw-600">{{$score}}</h4>
                                                @else
                                                <h4 class=" text-mute fw-600">0</h4>
                                                @endif
                                                <p class="mb-0">DA Score</p>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-3 stat-col">
                                                <div class="hstack gap-3 stat-items">
                                                    <div class="stat-icon icon-second">
                                                    <!-- <i class="fa-solid fa-chart-line"></i> -->
                                                    <i class="fas fa-sign-in"></i> 
                                                    </div>
                                                    <div class="stack-content">
                                                    <h4 class=" text-mute fw-600">{{$incount}}</h4>
                                                    <p class="mb-0">Links In</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 stat-col">
                                                <div class="hstack gap-3 stat-items">
                                                    <div class="stat-icon icon-second">
                                                    <!-- <i class="fa-solid fa-chart-line"></i> -->
                                                   <a href="https://{{$store}}/pages/outbound-links" target="_blank"><i class="fa-regular fa-file-lines"></i></a> 
                                                    </div>
                                                    <div class="stack-content">
                                                    <h4 class=" text-mute fw-600"></h4>
                                                    <p class="mb-0">Outbound Links</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                  </div>                               
                                                @endif
                                                <div id="container"></div>
                                                
                                         </div>
                                      </div>
                                 </div>
                                </div>
                               
                         
                            <!-- dashboard tab end -->

                            <!-- search tab start -->
                             <div class="tab-pane fade " id="pills-search" role="tabpanel"
                                aria-labelledby="pills-search-tab" tabindex="0">
                                <div class="tab-content-wrap">
                                 
                                  <div class="alert alert-warning fade show" id="alertMessage1" role="alert">
                                            <strong id="username3">Users must first enable their links, by clicking on 'Pending', before publishing them.</strong>
                                      </div>
                                <div class="loader" style="display:none;">
                                    <img src="{{ asset('assets/images/loader_icon.jpg') }}" class="loader-img" />
                                </div>
                                    <input type="hidden" id="inputstore" datas-store="{{$store}}">
                                    <div class="table-wrap table-responsive">
                                 
                                      @yield('main')
                                      
                             <div class="data-table-wrap">
                                    <table class="table mb-0" id="datatables">
                                        <thead>
                                        <tr>
                                            <th scope="col">S.no</th>
                                          
                                            <th scope="col">Title</th>
                                            <th scope="col">Vendor</th>
                                          
                                            <th scope="col">Keyword</th>
                                           
                                            <th scope="col">Type</th>
                                           
                                            <th scope="col">Created</th>
                                           
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                            </thead>
                                            <tbody id="response">
                                            
                                                <tr>
                                              
                                                <td><span></span></td>
                                        
                                                <td><span></span></td>
                                                <td><span></span></td>
                                            
                                                <td><span></span></td>
                                            
                                                <td><span></span></td>
                                                
                                                <td><span></span></td>
                                                
                                                    <td >
                                                        <div class="hstack gap-3 justify-content-center">
                                                        
                                                        </div>
                                                    </td>
                                            </tr>
                                            
                                        </tbody> 
                                        
                                    </table>
                                    </div>
                                    
                                      
                                    </div>
                                </div>
                             </div> 
                            <!-- search tab end -->

                            <!-- inbound tab start -->
                            <div class="tab-pane fade" id="pills-inbound" role="tabpanel"
                                aria-labelledby="pills-inbound-tab" tabindex="0">
                                <div class="tab-content-wrap">
                               
                             <div class="table-wrap table-responsive ">
                                          
                                  <div class="data-table-wrap">
                                    <table class="table mb-0 inbound-datatable " id="inbound-datatable">
                                        <thead>
                                        <tr>
                                            <th scope="col">S.no</th>
                                           
                                            <th scope="col">Title</th>
                                            <th scope="col">Vendor</th>
                                     
                                            <th scope="col">Tags</th>
                                        
                                            <th scope="col">Type</th>
                                           
                                            <th scope="col">Created</th>
                                            
                                        </tr>
                                            </thead>
                                            <tbody id="inbound-response">
                                                @php $number=1; @endphp
                                                @if(isset($productslist))
                                            @foreach($productslist as $product)
                                                <tr>
                                                <td><span>{{$number++}}</span></td>
                                                <td ><span><a href="{{$product->link}}" target="_blank" >{{ Illuminate\Support\Str::limit($product->title, 15) }}</a></span></td>
                                                <td><span>{{$product->vendor}}</span></td>
                                                <td><span>{{ Illuminate\Support\Str::limit($product->tags, 10) }}</span></td>
                                                
                                                <td><span>{{$product->type}}</span></td>
                                                
                                             
                                                <td><span>{{ Illuminate\Support\Str::limit($product->created_at, 11,"") }}</span></td>
                                                
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody> 
                                        
                                    </table>
                                </div>
                                      
                                        
                                    </div>
                                </div>
                            </div>
                            <!-- inbound tab end -->

                            <!-- inbound tab strat -->
                            <div class="tab-pane fade" id="pills-outbound" role="tabpanel"
                                aria-labelledby="pills-outbound-tab" tabindex="0">

                                <div class="tab-content-wrap">
                                <div id="icon"  style="display: none;">
                                        <img src="{{ asset('assets/images/loader_icon.jpg') }}" height="200px" class="loader-img" />
                                    </div>
                                    <form id="form3" action="{{ route('outbound',['shop'=>$store])}}" method="post">
                            <div class="unb-col mb-4">
                                 <div class="select-wrap row">
                              
                                        <div class="col-sm-6">
                                            <label class="form-label">(Step:1) Choose Outbound Link</label>
                                        <div class="input-group input mb-3">
                                        <select  class="form-control min-48 addlinks enable change getkey" 
                                              id="add" name="add" required>
                                                <option></option>
                                        </select>
                                     </div>
                                       </div>
                                       <div class="col-sm-6">
                                    <label class="form-label"> (Step:2)Choose Keyword</label>
                                    
                                    <div class="mb-2" >
                                           <select class="js-select2 js-select1 disable enable1 addkeywords" id="js-select5" name="val3"  required>
                                                <option></option>
                                               
                                                <!-- <option value="6">BestApp</option>
                                                <option value="7">GreatApp</option> -->
                                               
                                            </select>
                                           <span class="span3"></span> 
                                                
                                    
                                      </div>
                                    </div>
                                       <div class="col-sm-6">
                                       <label class="form-label">(Step:3)Choose Category</label>
                                          <div class="mb-2" >
                                         
                                            <select class="js-select2 js-select22 disable enable2" id="js-select"  required>
                                                <option></option>
                                                <option value="1">Products</option>
                                                <option value="2">Blogs</option>
                                                <option value="3">Pages</option>
            
                                            </select>
                                        </div>
                                    </div>
                                     <!-- <div class="loader" style="display:none;"> -->
  
                                    <div class="col-sm-6">
                                    <label class="form-label">(Step:4) Choose Link</label>
                                    <div class="mb-2 " >
                                           <select class="js-select2 js-select21 reset1 disable enable3" id="js-select2" name="val1"  required>
                                                <option></option>
                                            </select>
                                            <span class="span1"></span> 
                                        
                                    </div>
                                    </div>
                                     
                                    
                                            <input type="hidden" name="storename" class="inputclass" id="input" value="{{ $store }}">
                                            <div id="hidden">
                                           
                                            </div>
                                            <div id="hiddenval">
                                           
                                            </div>
                                            <input type="hidden" class="hidden-title-input">
                                 </div>
                                  <div class="col-12 text-end">
                                        <div class="btn-wrap">
                                            <button class="btn primary-btn sub" type="submit" id="outbound" data="{{ $store }}"  >
                                                Add outbound link
                                            </button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="table-wrap table-responsive">
                                    <div class="data-table-wrap">
                                    <table class="table mb-0 outbound-datatable " id="outbound-datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.no</th>
                                                    <th scope="col">Storename</th>
                                                    <th scope="col">Outbound Link</th>
                                                    <!-- <th scope="col">Handle</th>       -->
                                                    <th scope="col">Created</th>
                                                    <!-- <th class="text-center" scope="col">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody id="outbound-response">
                                                @php $number=1;$message="No Store";$msg="No Link" @endphp
                                                @if(isset($outboundlist))
                                            @foreach($outboundlist as $product)
                                            
                                                <tr>

                                                <td><span>{{$number++}}</span></td>
                                                @if(isset($product->outbound_store))
                                                <td><span>{{$product->outbound_store}}</span></td>
                                                @else
                                                <td><span>{{$message}}</span></td>
                                                @endif
                                                @if($product->outbound_link)
                                                <td><span style="color:orange;"><a href="{{$product->outbound_link}}" target="_blank">{{$product->title}}</a></span></td>
                                                @else
                                                <td><span>{{$msg}}</span></td>
                                                @endif
                                                <!-- <td class="handle"><span>{{$product->handle}}</span></td> -->
                                                <td><span>{{ Illuminate\Support\Str::limit($product->created_at, 11,"") }}</span></td>
                                               
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody> 
                                        
                                    </table>
                                        
                                    </div>
                                </div>
                            </div>
                             
                            </div>
                            <!-- inbound tab end -->
                            <div class="tab-pane fade" id="pills-settings" role="tabpanel"
                                aria-labelledby="pills-settings-tab" tabindex="0">

                                <div class="tab-content-wrap" >
                                <!-- <label class="form-label"> Enter Keyword:</label> -->
                                
                                <div class="select-wrap row ">
                                <form id="form5" action="{{ route('keyword',['shop'=>$store])}}" method="post">
                             <div class="col-sm-6">
                              <label class="form-label"> Enter Keyword:</label>
                                     <div class="mb-2">
                                      <input type="text" class="form-control validinput" placeholder="Enter keyword"
                                          aria-label="Add Your Keywords" aria-describedby="button-addon2"id="set"  name="settings" required>
                                          <input type="hidden" class="baseurl userkeywords " data-store="{{$store}}" id="userkeywords">
                                      <!-- <button class="btn primary-btn validbtn" type="submit" id="button-addon4">Submit</button>  -->
                                      <span id="username2" style="color:black;"></span>
                              </div> 
                              <div class="col-12 text-left " >
                                        <div class="btn-wrap">
                                        <button class="btn primary-btn validbtn" type="submit" id="button-addon4">Submit</button>
                                            </div>
                                        </div>
                             </div>
                             </form>  
    
                             <form id="form2" action="{{route('da',['shop'=>$store])}}" method="post">
                             <div class="col-sm-6">
                              <label class="form-label" for=""><a href="https://websiteseochecker.com/domain-authority-checker/" target="_blank">How to check your DA score</a></label>
                          
                          <div class="mb-2" >
                          <input type="text" class="form-control score base" placeholder="Add Your DA score"
                                            aria-label="Add Your DA score" aria-describedby="button-addon2"id="num"  name="search"  required>
                                            <input type="hidden" class="baseurl" data-store="{{$store}}" id="name">
                                      
                                            <span id="inputda" style="color:black;"></span>
                            </div>
                            <div class="col-12 text-left">
                                        <div class="btn-wrap">
                                        <button class="btn primary-btn da_btn" type="submit" id="button-addon2">Submit</button>
                                            </div>
                                        </div>
                          </div>
                              </form>
               
                                        <div class="alert alert-dismissible fade show" id="alertMessage" role="alert" style="display:none;">
                                         
                                         <!-- <span aria-hidden="true">&times;</span> -->
                                     
                                      <span id="username1"></span>
                                      
                                 </div>
                                
                       </div>
                                  
                                    
                                 <div id="hiddenid">

                                     </div>
                                
                                </div>
                               
                                <div class="table-wrap table-responsive">
                                    <div class="data-table-wrap">
                                    <table class="table mb-0 setting-datatable " id="setting-datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.no</th>
                                                   
                                                    <th scope="col">Keywords</th>
                                                     
                                                    <th scope="col">Action</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody id="setting-response">
                                                @php $number=1;$message="No Store";$msg="No Link" @endphp
                                                @if(isset($keywordlist))
                                            @foreach($keywordlist as $product)
                                            
                                                <tr>

                                                <td><span>{{$number++}}</span></td>
                                                
                                                <td><span>{{$product->keyword}}</span></td>
                        
                                             
                                                <td><span> <button class="btn primary-btn " type="submit" id="button-addon5" data-key="{{$product->id}}">Delete</button> </span></td>
                                               
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody> 
                                        
                                    </table>
                                </div>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="pills-plans" role="tabpanel"
                                aria-labelledby="pills-plans-tab" tabindex="0">
                                <div class="tab-content-wrap">
    <div class="row align-items-stretch">
        <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Free Plan</h5>
                        <h2 class="card-title"><b>Free</b></h2>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Bronze Plan</h5>
                    <h2 class="card-title"><b>$19.99/month</b></h2>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    @if($planstatus=="active" && $plan=="bronze")
                    <button class="btn btn-success">Activated</button>
                    @else
                   <a href="{{route('plan',['shop'=>$store,'name'=>'bronze'])}}"> <button class="btn btn-primary">Upgrade</button></a>
                   @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Silver Plan</h5>
                    <h2 class="card-title"><b>$49.99/month</b></h2>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  @if($planstatus=="active" && $plan=="silver")
                    <button class="btn btn-success">Activated</button>
                    @else
                   <a href="{{route('plan',['shop'=>$store,'name'=>'silver'])}}"> <button class="btn btn-primary">Upgrade</button></a>
                   @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Gold Plan</h5>
                    <h2 class="card-title"><b>$59.98/month</b></h2>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                   @if($planstatus=="active" && $plan=="gold")
                    <button class="btn btn-success">Activated</button>
                    @else
                   <a href="{{route('plan',['shop'=>$store,'name'=>'gold'])}}"> <button class="btn btn-primary">Upgrade</button></a>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>


                            </div>
                </div>
                <!-- manin tab end -->
            </section>
        </main>
        <!-- main content end -->

        <!-- Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="product_model">
                         
                        </h5>
                        
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn primary-btn-outline" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="bootmodal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="prod_model">
                         
                        </h5>
                        
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn primary-btn-outline" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header align-items-start">
                        
                     <div class="head-select ">
                          <select  id="mySelect">
                            <option value="0">Choose The Options</option>
                            <option value="1" >Products</option>
                            <!-- <option value="2" >Blogs</option>
                            <option value="3">Pages</option> -->
                          </select>
                    </div>
                        <div class="head-btn">
                          <button type="button" class="btn primary-btn btn2" data-bs-toggle="modal"
                                    data-bs-target="#blogs" data-value="0" >
                                    Fetch  Data
                           </button>
                        
                        
                           <a href="{{route('product',['shop'=>$store])}}" style="display: block;"> <button type="button" class="btn primary-btn btn1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-value="1">
                                    Fetch Data
                           </button> </a>
                        
                        
                           <!-- <a href="{{route('blogs',['shop'=>$store])}}"  style="display: block;">  <button type="button" class="btn primary-btn btn1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-value="2">
                                    Fetch Data
                           </button> </a>

                          
                           <a href="{{route('pages',['shop'=>$store])}}" style="display: block;"> <button type="button" class="btn primary-btn btn1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" data-value="3">
                                    Fetch Data
                           </button> </a> -->
                       
                       </div> 
                        
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn primary-btn-outline" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>  


    
    
    <script>
        $(document).ready(function () {
        // Add a click event handler to the "Search" button
        $('.addtab').on('click', function () {
            // Remove the 'active' class from all nav links with class 'removeactive'
           
          console.log ($('#pills-dashboard-tab').removeClass('active'));
            // // Add the 'active' class to the specific nav link with class 'makeactive'
          console.log(  $('#pills-search-tab').addClass('active'));
        
            // alert();
        });
    });
        $(document).ready(function () {
            $(".js-select22").select2({
                dropdownCssClass: "big-drop",
                placeholder: "Choose Your Category"
            });
        });
        $(document).ready(function () {
            $("#add").select2({
                dropdownCssClass: "big-drop",
                placeholder: "Choose Outbound Link"
            });
        });
        $(document).ready(function () {
            $(".js-select21").select2({
                dropdownCssClass: "big-drop",
                //placeholder: "Choose Your Option"
            });
        });
        // $(document).ready(function () {
        //     $(".js-select3").select2({
        //         dropdownCssClass: "big-drop",
        //         placeholder: "Choose Location"
        //     });
        // });
        $(document).ready(function () {
            $(".js-select1").select2({
                dropdownCssClass: "big-drop",
                placeholder: "Choose Keyword"
            });
        });
        $(document).ready(function()
        {
            $ (".btn2").show();
            $ (".btn1").hide(); 
            $("select").change(function()
        {
        // alert("The text has been changed.");
          $ (".btn1").hide();
          var selectedValue = $(this).val();
          $(".btn1[data-value='" + selectedValue + "']").show();
        //    $("a[data-val='" + selectedValue + "']").show();
            if(selectedValue!=="0")
            {
                $(".btn2[data-value='" +0+ "']").hide();
            }
          else
            {
                
                $(".btn2[data-value='" +0+ "']").show();
            }
        });
        $('#Modal').modal
        ({
            backdrop: 'static',
            keyboard: false
        });
        });

        //  $(document).ready(function(){
        //   $("#datatable").dataTable(); 
        //  });
        
         $(document).ready(function(){
          $(".inbound-datatable").dataTable(); 
         });
         $(document).ready(function(){
          $(".setting-datatable").dataTable(); 
         });
         $(document).ready(function(){
          $("#outbound-datatable").dataTable(); 
         });

         $(document).ready(function(){
				 $("#num").keydown(function(er)
				 {
					 var key=er.keyCode;
						if(!((key==8)||(key==46)||(key>=35 && key<=40)||(key>=48 && key<=57)||(key>=96 && key<=105)))
						{
							 er.preventDefault();
                             
						}
					});
                    
				});
         
               
$(document).ready(function(){
    var store=$('#inputstore').attr('datas-store');
    $("body").addClass("blur-background"); // Add blur class to body
        $(".loader").show();
      $.ajax({
        url:"https://localhost/shop_app/search",
        method:"post",
        data:{store:store},
        success:function(response){
            $('.loader').hide();
             $("body").removeClass("blur-background");
            var data=response.additionalData.products;
            var key=response.additionalData.keyword;
            var newkey=response.additionalData.productslist;
            
            


 var table=$('#datatables').DataTable({
  //  paging: false,
    data: data,
    pageLength: 10,
   
    columns: [
      //  { title: 'S.no', data: 'id' },
      { title: 'S.no', render: function (data, type, row, meta) {
                        // Use the meta data to get the row index and add 1 to get the serial number
                        return meta.row + 1;
                    }},
        { title: 'Title', data: 'title',
            render: function (data, type, row) {
                            
                            return limitCharacters(data, 11);
                        }
          },
        { title: 'Vendor', data: 'vendor' },
        { title: 'Keywords', 
            render: function (data, type, row) {
            
                            var select = '<select class="form-control myid" >';
                            select += '<option></option>'; // Add an empty option as per your requirement
                            
                            if ( Array.isArray(key)) {
                                
                                key.forEach(function(item) {
                                    if(item.status=="0")
                                    {
                                    select += '<option value="' + item.status + '">' + item.keyword + '</option>';
                                    }
                                    // else
                                    // {
                                    //     select += '<option value=""></option>';
                                    // }
                                });
                            
                        }
                            select += '</select>';
                        
                           
                            return select;
                        }
             
        
         
                    },
        
        {
            title: 'Type',
            data: 'type',
           
        },
        {
            title: 'Created',
            data: 'created_at',
            render: function (data, type, row) {
                            // Use Str::limit to restrict the number of words in created_at
                            return limitCharacters(data, 10);
                        }
           
        },
        { title: 'Action',data:'null',
            render: function (data, type,row) {
                           
                            // var addButton = '<button class="btn primary-btn-outline list-btn" data-id="' + row.id + '" type="submit" data="' + row.link + '" store="' + row.storename + '">Add to list</button>';
                            var penButton = '<button class="btn primary-btn-outline pending-btn " id="pending"  data-href="'+row.id+'"data="'+row.status+'" datas="'+row.link+'" store="'+row.storename+'">Pending</button>';
                            var viewButton = '<button class="btn primary-btn btn_ajax" data-bs-toggle="modal" id="viewbtn" data-prod-id="' + row.id + '">View Details</button>';
                            var pubButton='  <button class="btn primary-btn published-btn " data-href="'+row.id+'"data="'+row.status+'" >Published</button>';
                        $('.pending-btn, .published-btn').each(function() {
                        var status = $(this).attr("data");
                        var id = $(this).attr("data-href");
                        if (status === "0") {
                            $(".pending-btn[data='" + status + "'][data-href='" + id + "']").show();
                            $(".published-btn[data='" + status + "'][data-href='" + id + "']").hide();
                        } else if (status === "1") {
                            $(".pending-btn[data='" + status + "'][data-href='" + id + "']").hide();
                           $(".published-btn[data='" + status + "'][data-href='" + id + "']").show();
                        }
                    });
                      
                            return penButton + ' ' + pubButton+ ' ' + viewButton;
                        }
                     
            }
       
    ],
  
    createdRow: function(row, data, dataIndex) {
        // Access the row's cells to find and manipulate the buttons
        var status = $(row).find('.pending-btn').attr('data');
        var id = $(row).find('.pending-btn').attr('data-href');
        $(row).find('.myid').attr('id', 'myid_' + dataIndex);
        // var newStatus = $('.myid  option:selected').attr('newstatus');
        // console.log(newstatus);
        if (status === "0") {
            $(row).find('.pending-btn').show();
            $(row).find('.published-btn').hide();
        } else if (status === "1") {
            $(row).find('.pending-btn').hide();
            $(row).find('.published-btn').show();
        }
    },
   
    

})
$(document).on('click','.pending-btn',function(){
        

        if(!confirm('Are you sure you want to publish it'))
        {
         event.preventDefault();
        }
        else
        {
         
        var ids=$(this).attr('data-href');
        var store=$(this).attr("store");
        var link=$(this).attr("datas");
        var keys=$('#myid_' + $(this).closest('tr').index() + ' option:selected').text();
        console.log(keys);
         $.ajax({
              url:"https://localhost/shop_app/publishdata",
              method:"post",
              data:{id:ids,store:store,link:link,keys:keys},
              success:function(response){
                
                 var input='<input type="hidden" name="hiddenval" id="inbound" value='+response.id+'>'
                 $("#hidden").html(input);
                 if(response.data['id'])
                 {
                 var inputid='<input type="hidden" name="hide" id="inboundid" class="inboundid" value='+response.data['id']+'>'
                $("#hiddenid").html(inputid);
                 }
                 
                 var inboundlink='<input type="hidden" name="hiddenval" id="inboundlink" value='+response.data['link']+'>'
                 $("#hiddenval").html(inboundlink);
                 if(response.data['message']=="Can not submit inbound links")
                 {
                     $("#prod_model").html(response.data['message']);
                     $("#bootmodal").modal("show");
                     // $('body').css("overflow", "hidden");
                 }
               if(response.data['datas']=="1")
               {
               $(".pending-btn[data-href='" + ids + "']").hide();
               $(".published-btn[data-href='" + ids + "']").show();
               }
               else if(response.data['datas']=="0")
               {
                $(".pending-btn[data-href='" + ids + "']").show();
                $(".published-btn[data-href='" + ids + "']").hide();
               }
               if(response.data['keyerror'])
               {
                $("#prod_model").html(response.data['keyerror']);
                 $("#bootmodal").modal("show");
               }
               if(response.data['success'])
               {
                $("#prod_model").html(response.data['success']);
                 $("#bootmodal").modal("show");
               }
               if(response.data['plan1'])
               {
                $("#prod_model").html(response.data['plan1']);
                 $("#bootmodal").modal("show");
               }
               if(response.data['planerror'])
               {
                $("#prod_model").html(response.data['planerror']);
                 $("#bootmodal").modal("show");
               }
             
              }
        
         });
         
        
        }
        });
        }
        
      }) 
    })
     
//             var selectedResourceId;
//             $(document).ready(function(){
               
//             $(document).on('change','.js-select22',function(){

//                  $("body").addClass("blur-background"); // Add blur class to body
//         $("#icon").show();
//     var ids = $(this).val();
//     var store = $('[name="storename"]').val();
//     console.log(ids);
//     $.ajax({
//           url:"https://localhost/shop_app/fetch",
//           type:"post",
//           data:{ids:ids,store:store},
//           success:function(data)
//           {
//             $('#icon').hide();
//              $("body").removeClass("blur-background");
//             var datas="";
//         var filteredData = data.datas.filter(function (item) {
//                 switch (ids) {
//                     case "1":
//                         return item.product_id !== null;
//                     case "2":
//                         return item.blog_id !== null;
//                     case "3":
//                         return item.page_id !== null;
//                     default:
//                         return false;
//                 }
//             });

//             // Populate options based on filtered data
//             for (var i = 0; i < filteredData.length; i++) {
//                 switch (ids) {
//                     case "1":
//                         datas += '<option value="' + filteredData[i].handle + '">' + filteredData[i].handle + '</option>';
//                         break;
//                     case "2":
//                         datas += '<option value="' + filteredData[i].handle + '">' + filteredData[i].handle + '</option>';
//                         break;
//                     case "3":
//                         datas += '<option value="' + filteredData[i].handle + '">' + filteredData[i].handle + '</option>';
//                         break;
//                 }
//             }

//              $('#js-select2').html(datas);
           
//       $("#outbound").click(function(e){
//         e.preventDefault();
//        // var formData = new FormData($('#form3')[0]);
//         var add=$("#add").val();
//         var type= $('#js-select option:selected').text();
//         var input=$("#input").val();
//         var inboundid=$("#inbound").val();
//         var link=$("#inboundlink").val();
//         var title=$(".hidden-title-input").val();
//         var keyword=$("#js-select5 option:selected").text();
//     //    var id = $('#js-select3').val();
//     // var id = $('#js-select3 option:selected').text();
//    // console.log(id);
//        selectedResourceId = $('#js-select2').val();
//         //console.log(add,input,id)
//        $.ajax({
//         url:"https://localhost/shop_app/outbound",
//           type:"post",
//           data:{add:add,input:input,inboundid:inboundid,selectedResourceId:selectedResourceId,type:type,link:link,title:title,keyword:keyword},
//           success:function(response){
//             $('#form3')[0].reset();
//             // $('#add').val('').trigger('change');
//             // $('#js-select').val('').trigger('change');
//             // $('#js-select3').val('').trigger('change');
//             // $('#js-select5').val('').trigger('change');
//             // $('#js-select2').val(null).trigger('change');
//             if(response.data=="Please fill all the fields")
//                 {
//                   $("#prod_model").html(response.data);
//                   $("#bootmodal").modal("show");
//                 }
//             if(response.message1)
//                 {
//                   $("#prod_model").html(response.message1);
//                   $("#bootmodal").modal("show");
//                 }
//                 if(response.error)
//                 {
//                     $("#prod_model").html(response.error);
//                   $("#bootmodal").modal("show");
//                 }
//                 if(response.error1)
//                 {
//                     $("#prod_model").html(response.error1);
//                   $("#bootmodal").modal("show");
//                 }
//           }
//        });
//       });

//      //   });
//         }
//     });
// });
// });
// $(document).on('click','.viewlink',function(){
//     var store=$(".baseurl").attr("data-store");
//     var link=$(this).attr('data-link');
//     console.log(link);
//     $.ajax({
//         url:"https://localhost/shop_app/viewlinks",
//         method:"post",
//         data:{store:store,link:link},
//         success:function(response){
//             // $("#prod_model").html(response);
//             // $("#bootmodal").modal("show");
//             if(response !=""){
//             var listHtml = '<h2 align="center"><b><u>Page Title</u></b></h2>'+
//             "<ul>";
//             response.forEach(function (item) {
//                 //var fullUrl = "http://" + item;
//                 listHtml += "<li>" + '<a href='+item.link+' target="_blank">'+item.title +'</a>'+ "</li>";
//            });
//             listHtml += "</ul>";
           
//             $("#prod_model").html(listHtml);
//             $("#bootmodal").modal("show");
//         }
//             if(response =="")
//             {
//                 var listHtml = '<h2 align="center"><b><u>Page Title</u></b></h2>'+'<br>'+
//                   'This link has not been used by any store yet'
                  

//             $("#prod_model").html(listHtml);
//             $("#bootmodal").modal("show"); 
//             }
//         }
        

        
//     });
// })
$(document).ready(function(){
     var store=$("#name").attr("data-store");
    
   $.ajax({
    url:"https://localhost/shop_app/score",
    method:"post",
    data:{store:store},
    success:function(response){
          $(".score").val(response);
    }
   });
});

// $(document).ready(function(){
//                var storename=$(".inputclass").val();
//                // console.log(storename);
//                 $.ajax({
//                     url:"https://localhost/shop_app/links",
//                     type:"post",
//                     data:{storename:storename},
//                     success:function(response){
//                         //console.log(response.data)
                        
//                         if (Array.isArray(response.data)) {
//                 // Map the array to a string of option elements
//                 var options = ['<option value="">Select an option</option>'];
//                 options =options.concat (response.data.map(function(item) {
//                     return '<option value="' + item.link + '">' +item.title+'('+ item.link +')'+ '</option>';
//                     var id=item.id;
//                  //   console.log(id);
//                 }));
               
               
//                 var datas = options.join('');
//                 $(".addlinks").html(datas);
//                 $(".addlinks").change(function () {
//                     var selectedIndex = $(this).prop("selectedIndex");
//                     // var selectedTitle = response.data[selectedIndex - 1].title; // Adjust index as it is 0-based
//                     // $(".hidden-title-input").val(selectedTitle);
                   
//                         var selectedInboundId = response.data[selectedIndex - 1].id;
                       
//                         var selectedTitle = response.data[selectedIndex - 1].title;
                       
                     
//                         $(".hidden-title-input").val(selectedTitle);
                        
                    
//                                 var store=$(".userkeywords").attr("data-store");
                            
                                    
//                             $.ajax({
//                                 url:"https://localhost/shop_app/popkey",
//                                 method:"post",
//                                 data:{store:store,selectedInboundId:selectedInboundId},
//                                 success:function(secresponse){
                                    
//                                     // if (Array.isArray(secresponse.data)) {
//                                     //     // Map the array to a string of option elements
//                                     //     var options = ['<option value="">Select an option</option>'];
//                                     //     options =options.concat (secresponse.data.map(function(item) {
//                                     //         return '<option value="' + item.id + '">' +item.keyword+ '</option>';
//                                     //     }));
                                    
                                        
//                                     //     var datas = options.join('');
//                                     //     $(".addkeywords").html(datas);
//                                     //     }
//                                     if (secresponse.data) {
//                                         // Map the object keys to a string of option elements
//                                         var options = ['<option value="">Select an option</option>'];
//                                         options = options.concat(Object.keys(secresponse.data).map(function (key) {
//                                             return '<option value="' + key + '">' + secresponse.data[key] + '</option>';
//                                         }));

//                                         var datas = options.join('');
//                                         $(".addkeywords").html(datas);
//                                     }
//                                          }
//                                      });
                        
//                                         });

                                        
//                                     }
//                                             }
//                                         });
//                                     });

            $(document).ready(function()
        {
           // $(".data-table-hide").show();
            $("#button-addon1").click(function(){
                // var oTable = $('.data_table').dataTable(); // 'example is the table id'
                //  oTable.hide();
                $(".data-table-hide").hide(); 
            });   
        });
        

// Disable text selection for elements
// with class "no-select"
            // $( ".disable" ).prop( "disabled", true );
            // $(document).on("change",".enable",function(){
            //     $(".enable1").prop("disabled",false)
            //     $(document).on("change",".enable1",function(){
            //     $(".enable2").prop("disabled",false)
            //     $(document).on("change",".enable2",function(){
            //     $(".enable3").prop("disabled",false)
            // //     $(document).on("change",".enable3",function(){
            // //     $(".enable4").prop("disabled",false)
            // // });
            // });
            // });
            // });
   
       



    $(document).ready(function () {
        $(document).on('click','.btn_ajax',function(){
          //  alert();
        // $("#searchModal").modal('show');
        var id=$(this).attr("data-prod-id");
       // console.log(id);
      
        $.ajax({
             url:"https://localhost/shop_app/showdata",
             method:"post",
             data:{id:id},
             success: function (response){
               // console.log('here, Im test = ',$("#exampleModalLongTitle").html());
              // alert();
                  
               var modalContent = 
                    "<b>Image</b>:" + '<img src='+response.image+'>' + "<br>" +
                    "<b>Title</b>: " + response.title + "<br>" +
                    "<b>Vendor</b>: " + response.vendor + "<br>" +
                    //  "<b>Options</b>: " + data + "<br>" +
                    "<b>Options</b>: " + response.options + "<br>" +
                    "<b>Product_Type</b>: " + response.product_type+"<br>"+
                    "<b>Tags</b>:"+response.tags;
               $("#product_model").html(modalContent);
              // $("#product_model").text(response.body_html);
                $("#searchModal").modal("show");
             }

            

        });
       });
        });
      
        
//         $(document).ready(function () {
//          $(document).on('click',".list-btn",function () {
//         var id = $(this).attr("data-id");
//         var store=$(this).attr("store");
//       //  var link=$(this).attr("data");
//         $.ajax({
//             url: "https://localhost/shop_app/inbound",
//             method: "post",
//             data: { id:id,store:store },
//             success: function (response) {
//              console.log(response.productslist);
              
//                 if(response.customMessage=="This link has already been added to the list")
//                 {
//                   $("#prod_model").html(response.customMessage);
//                   $("#bootmodal").modal("show");
//                 }
//                 else if(response.message=="Link has been added to the list!<br>Please refresh your app once after adding it to the list")
//                 {
//                   $("#prod_model").html(response.message);
//                   $("#bootmodal").modal("show");
//                 }
//             }
//         });
//     });
//  });  

 function limitCharacters(str, limit) {
    return str.length > limit ? str.substring(0, limit) + '...' : str;
}

    </script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    
    var inuserData = <?php echo json_encode($inuserData)?>;
    var userData = <?php echo json_encode($userData)?>;
    console.log(userData);
    var inuserDataArray = Object.entries(inuserData).map(([date, count]) => {
    return [Date.parse(date), count];
});

// Convert userData object to array
var userDataArray = Object.entries(userData).map(([date, count]) => {
    return [Date.parse(date), count];
});

    Highcharts.chart('container', {
        chart:{
              type:'line'
        },
        title: {
            text: 'Inbound VS Outbound'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            
            type: 'datetime', // Specify datetime type for X-axis
            dateTimeLabelFormats: {
                month: '%b',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
          
          
        },
        
        yAxis: {
            title: {
                text: 'Total Counts'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [
            {
            name: 'Inbound links',
            data: userDataArray 
        },
        {
            name: 'Outbound links',
            data: inuserDataArray
        }],
        
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
    $(document).ready(function(){
    $("#form5").submit(function(e){
         e.preventDefault();
         var store=$("#userkeywords").attr("data-store");
         var keyword=$("#set").val();
         var id=$("#inboundid").val();
       
         $.ajax({
            url:"https://localhost/shop_app/keyword",
            method:"post",
            data:{store:store,keyword:keyword,id:id},
            success:function(response){
                $('#form5')[0].reset();
               if(response)
               {
               
               $("#username1").html(response);
                $("#alertMessage").removeClass("alert-dismissible").addClass("alert-success").show();
               }
              

            }
         });
            
      //  } 
    });
    });
    $(document).ready(function(){
    $("#form2").submit(function(e){
         e.preventDefault();
         var store=$("#name").attr("data-store");
        
         var da_score=$('.base').val();
         $.ajax({
            url:"https://localhost/shop_app/dascore",
            method:"post",
            data:{store:store,da_score:da_score},
            success:function(response){
                $('#form2')[0].reset();
               if(response)
               {
               
               $("#username1").html(response);
                $("#alertMessage").removeClass("alert-dismissible").addClass("alert-success").show();
               }
              

            }
         });
            
      //  } 
    });
    });
   
   
    //   $(document).ready(function(){
    //     var store=$(".userkeywords").attr("data-store");
    //     // var ids=$('#inboundid').val();
    //    // console.log(ids);
       
    //     $(document).on('change','.change',function(){
            
    //    $.ajax({
    //       url:"https://localhost/shop_app/popkey",
    //       method:"post",
    //       data:{store:store},
    //       success:function(response){
            
    //         if (Array.isArray(response.data)) {
    //             // Map the array to a string of option elements
    //             var options = ['<option value="">Select an option</option>'];
    //             options =options.concat (response.data.map(function(item) {
    //                 return '<option value="' + item.id + '">' +item.keyword+ '</option>';
    //             }));
               
                
    //             var datas = options.join('');
    //             $(".addkeywords").html(datas);
    //       }
    //     }
    //    });
    // });
    // });
    $(document).ready(function(){
			  $(".validbtn").click(function(){
                    let input=$('#num').val();
					if(username=="")
					{
						if(username=="")
						{
							//$(".validinput").css("borderColor","red");
							$("#username2").html("This field is required");
                            
						}
						else
                        {
							//$(".validinput").css("borderColor","");
							$("#username2").html("");
						}
                    
						return false;
					}
					else
					{
						return true;
					}
					
			  });
              $(".validinput").focus(function () {
                     $("#username2").html("");
                     $("#alertMessage").hide();
                 });
               
			});
            $(document).ready(function(){
			  $(".da_btn").click(function(){
                    let input=$('#num').val();
					if( input=="")
					{
						
                        if(input=="")
						{
							//$(".validinput").css("borderColor","red");
							$("#inputda").html("This field is required");
                            
						}
						else
                        {
							//$(".validinput").css("borderColor","");
							$("#inputda").html("");
						}
						return false;
					}
					else
					{
						return true;
					}
					
			  });
             
                 $(".base").focus(function () {
                     $("#inputda").html("");
                     $("#alertMessage").hide();
                 });
			});
            
            $(document).on('click','#button-addon5',function(){
                var id=$(this).attr('data-key');
                if(!confirm("Are you sure you want to delete it"))
                {
                    event.preventDefault();
                }
                else
                {

                $.ajax({
                   url:'https://localhost/shop_app/delkey',
                   method:"post",
                   data:{id:id},
                   success:function(response){
                    $("#prod_model").html(response);
                    $("#bootmodal").modal("show");
                  //  $('#setting-datatable').DataTable().ajax.reload();
                   
                   }
                });
            }
            });
      

     
</script>
    @yield("footer")
</body>

</html>


