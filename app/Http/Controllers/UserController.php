<?php

namespace App\Http\Controllers;
use App\Jobs\Getproduct;
use App\Models\inboundlink;
use App\Models\outboundlink;
use App\Models\shopify_app;
use App\Models\shopifyproducts;
use App\Models\payment;
use Illuminate\Http\Request;
use Unirest\Request as Unirest;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Charts\Statuschart;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\FrameGuard;
use App\Models\check;
use App\Models\keyword;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use App\Models\plan;
use App\Models\freelinks;
use Illuminate\Support\Arr;
class UserController extends Controller
{ 
    public $shop;

    // public function __construct(Request $request) {
    //     //dd($request->all());
    //     $this->shop = $request['shop'];
    // }

    public function index(Request $request)
    {
       
             $store=$request['shop'];

            if($request->has('shop'))
            {
            $userData = inboundlink::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw("COUNT(*) as count"))
            ->whereYear('created_at', date('Y'))
            ->where("storename",$store)
            // ->groupBy(DB::raw("Month(created_at)"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->pluck('count','date');
            
            $inuserData = inboundlink::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw("COUNT(*) as count"))
            ->whereYear('created_at', date('Y'))
            ->where("outbound_store",$store)
            // ->groupBy(DB::raw("Month(created_at)"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->pluck('count','date');
          
            if(!payment::where('storename',$store)->exists())
            {
                $currentDateTime = Carbon::now()->format('Y-m-d');
                $newDateTime = Carbon::now()->addMonth();
                $payment = new payment();
                $payment->storename = $store;
                $payment->start_month=$currentDateTime;
                $payment->name ="free";
                $payment->status="active";
                $payment->save();
            }
            
            $incount=inboundlink::where("storename",$store)->where('status','1')->count();
            $outcount=outboundlink::where("storename",$store)->where('inbound_id','!=',"")->count();
            $score=shopify_app::where("storename",$store)->value("DA_score");

            $store=$request['shop'];
            $productslist=DB::table("tbl_inbound")
                    ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                    ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.handle","tbl_product.link","tbl_product.created_at","tbl_product.updated_at","tbl_inbound.inbound_id")
                    ->where("tbl_inbound.inbound_id","!=",'')
                    ->where("tbl_inbound.storename", "=", $store)
                    ->orderBy("tbl_product.title", "asc") 
                    ->get();  
                    $outboundlist=outboundlink::where("storename",$store)->where('outbound_link',"!=","")->orderBy("tbl_outbound.outbound_store", "asc")->get();
                    foreach($productslist as $key=>$val){
                    //  $inboundCounts = DB::table('tbl_outbound')->where('inbound_id', $val->inbound_id)->get();
                    $inboundCounts = DB::table('tbl_outbound')->where('outbound_link', $val->link)->get();
                    
                        $wordCount = $inboundCounts->count();
                        $productslist[$key]->link_count = $wordCount;    
                    }    
         
            $keywordlist=keyword::where('storename',$store)->orderBy("tbl_settings.keyword", "asc")->get();
            $planstatus=payment::where('storename',$store)->value('status');
            $plan=payment::where('storename',$store)->value('name');
            $data=compact('store','productslist','outboundlist','incount',"score",'inuserData','keywordlist','planstatus','plan','userData');
       
            return view('tab')->with($data);
        } 
        else
        {
            return view('/index');  
        }
    
    }
  
    public function indexes(Request $request,$store)
    {
 
                $userData = inboundlink::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->where("storename",$store)
                // ->groupBy(DB::raw("Month(created_at)"))
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                ->pluck('count','date');
                $inuserData = inboundlink::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw("COUNT(*) as count"))
                ->whereYear('created_at', date('Y'))
                ->where("outbound_store",$store)
                // ->groupBy(DB::raw("Month(created_at)"))
                ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                ->pluck('count','date');
                
            $incount=inboundlink::where("storename",$store)->where('status','1')->count();
            $outcount=outboundlink::where("storename",$store)->where('inbound_id','!=',"")->count();
            $score=shopify_app::where("storename",$store)->value("DA_score");

        $productslist=DB::table("tbl_inbound")
        ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
        ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.handle","tbl_product.link","tbl_product.created_at","tbl_product.updated_at","tbl_inbound.inbound_id")
        ->where("tbl_inbound.inbound_id","!=",'')
        ->where("tbl_inbound.storename", "=", $store)
        ->orderBy("tbl_product.title", "asc") 
        ->get();  
       
        $outboundlist=outboundlink::where("storename",$store)->where('outbound_link',"!=","")->orderBy("tbl_outbound.outbound_store", "asc")->get();
        foreach($productslist as $key=>$val){
           
            $inboundCounts = DB::table('tbl_outbound')->where('outbound_link', $val->link)->get();
            $wordCount = $inboundCounts->count();
            $productslist[$key]->link_count = $wordCount;    
        }

        $keywordlist=keyword::where('storename',$store)->orderBy("tbl_settings.keyword", "asc")->get();
        $customMessage = $request->input('customMessage', null);
        $customMessage1 = $request->input('customMessage1', null);
        $customMessage2 = $request->input('customMessage2', null);
        $customMessage3 = $request->input('customMessage3', null);
        $planstatus=payment::where('storename',$store)->value('status');
        $plan=payment::where('storename',$store)->value('name');
        $data=compact('store','productslist','outboundlist','incount',"score",'inuserData','keywordlist','planstatus','plan','userData');
         
       return view('tab')->with($data);
        
    }

    public function product_search(Request $request,Statuschart $chart)
    {
            $store=$_POST['store'];
            $query = $request->input('search');
            $inboundData = DB::table("tbl_inbound")
            ->where("storename", "=", $store)
            ->pluck("created_at")
            ->toArray();
        $outboundData = DB::table("tbl_outbound")
            ->where("storename", "=", $store)
            ->pluck("created_at")
            ->toArray();

        $xAxisLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $incount=inboundlink::where("storename",$store)->where('status','1')->count();
        $outcount=outboundlink::where("storename",$store)->where('inbound_id','!=',"")->count();
        $score=shopify_app::where("storename",$store)->value("DA_score");
        
        $productslist=DB::table("tbl_inbound")
                    ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                    ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.handle","tbl_product.link","tbl_product.created_at","tbl_product.updated_at","tbl_inbound.inbound_id")
                    ->where("tbl_inbound.inbound_id","!=",'')
                    ->where("tbl_inbound.storename", "=", $store)
                    ->orderBy("tbl_product.title", "asc") 
                    ->get();  
                
                    $outboundlist=outboundlink::where("storename",$store)->where('outbound_link',"!=","")->orderBy("tbl_outbound.outbound_store", "asc")->get();
                    $products=shopifyproducts::where('storename',$store)->orderBy("tbl_product.title", "asc") ->get();
                    $keyword=keyword::where('storename',$store)->select('keyword','id','status')->get();
                    
                
                    $data=compact('store','products','productslist','outboundlist','incount',"score",'keyword');
                    $chartData = $chart->build($inboundData, $outboundData, $xAxisLabels);
                    return [
                        'chart' => $chartData,
                        'additionalData' => $data,
                        
                    ];
    }
    
    public function instructions($store)
    {
        $store;
        $data=compact('store');
        return view('instructions')->with($data);
    }

    public function showdata()
    {


        $id=$_POST['id'];
        $productdata=shopifyproducts::find($id);
        return $productdata;
      
    }
    
    public function data_storage(Request $request )
    {
         $form=$request['shop'];
         session(['shop' => $form]);
         return redirect('/redirect');
    }

    public function redirect(Request $request)
    {
       
         $this->shop=session('shop'); 
        $nonce = base64_decode(rand(1, 100000));
        $clientid=config('app.SHOPIFY_CLIENT_ID');
        $shopifyscope=config('app.SHOPIFY_SCOPE');
        $redirecturi=config('app.REDIRECT_URI');
        return redirect('https://'.$this->shop.'/admin/oauth/authorize?client_id='.$clientid.'&scope='.$shopifyscope.'&redirect_uri='.$redirecturi.'&state='.$nonce.'
        ');
    }

    public function gettoken(Request $request)
    {
        
        $clientid = config('app.SHOPIFY_CLIENT_ID');
        $client_secret = config('app.Client_secret');
        $code = $request->input('code');
        $this->shop=$request['shop'];
        
        $response = Http::post('https://'.$this->shop.'/admin/oauth/access_token', [
            'client_id' => $clientid,
            'client_secret' => $client_secret,
            'code' => $code,
        ]);
        
        
        if ($response->successful()) {
            $data = $response->json();
            $access_token = $data['access_token'];
            $form=new shopify_app;
            $form->storename=$this->shop;
            $form->access_token=$access_token;
            $form->save();
           
        }
         $this->appuninstall();
         $this->product_create();
         $this->product_delete();
         $this->product_update();
         $this->page_create();
          $this->page_template();
        
      return redirect('https://'.$this->shop.'/admin');
        
    }
    
    public function payment($store,$plan)
    {
            
        $access_token=shopify_app::where('storename',$store)->value('access_token');
          
             if($plan=="bronze")
            {
            
                $intlinks=plan::where('name','bronze')->value('initial_links');
                $per_month=plan::where('name','bronze')->value('per_month');
                
               $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
                $data = [
                    'recurring_application_charge' => [
                        'name' => 'bronze',
                        'price' => 19.99,
                        'return_url' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/test?shop='.$store.'',
                        //"trial_days"=>5,
                        "test"=>"true"
                        
                    ],
                ];
                $response= Http::withHeaders($headers)->post('https://'.$store.'/admin/api/2023-10/recurring_application_charges.json',$data);
                // echo"<pre>";
                // print_r($response->json());die;
                $confirmation = $response->json()['recurring_application_charge']['confirmation_url'];
                $status=$response->json()['recurring_application_charge']['status'];
                $returnurl=$response->json()['recurring_application_charge']['return_url'];
                $decurl=$response->json()['recurring_application_charge']['decorated_return_url'];
                $responsedata=$response->json();
            
                $resp = $responsedata['recurring_application_charge'];
              
                $payment = payment::where('storename',$store)->first();
                $payment->storename = $store;
                $payment->confirmation=$confirmation;
                $payment->name = $resp['name'];
                $payment->start_month = $resp['billing_on'];
                $payment->store_count=$intlinks;
                $payment->per_month=$per_month;
                $payment->price = $resp['price'];
                $payment->charge_id= $resp['id'];
                $payment->status = $resp['status'];
                $payment->save();
                $data=compact('confirmation');
                return view('/url')->with($data);
            } 
            elseif($plan=="silver")
            {
            
                $intlinks=plan::where('name','silver')->value('initial_links');
                $per_month=plan::where('name','silver')->value('per_month');
                
               $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
                $data = [
                    'recurring_application_charge' => [
                        'name' => 'silver',
                        'price' => 49.99,
                        'return_url' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/test?shop='.$store.'',
                        //"trial_days"=>5,
                        "test"=>"true"
                        
                    ],
                ];
                $response= Http::withHeaders($headers)->post('https://'.$store.'/admin/api/2023-10/recurring_application_charges.json',$data);
                // echo"<pre>";
                // print_r($response->json());die;
                $confirmation = $response->json()['recurring_application_charge']['confirmation_url'];
                $status=$response->json()['recurring_application_charge']['status'];
                $returnurl=$response->json()['recurring_application_charge']['return_url'];
                $decurl=$response->json()['recurring_application_charge']['decorated_return_url'];
                $responsedata=$response->json();
            
                $resp = $responsedata['recurring_application_charge'];

                $payment = payment::where('storename',$store)->first();
                $payment->storename = $store;
                $payment->confirmation=$confirmation;
                $payment->name = $resp['name'];
                $payment->start_month = $resp['billing_on'];
                $payment->store_count=$intlinks;
                $payment->per_month=$per_month;
                $payment->price = $resp['price'];
                $payment->charge_id= $resp['id'];
                $payment->status = $resp['status'];
                $payment->save();
                $data=compact('confirmation');
                return view('/url')->with($data);
            }   
            elseif($plan=="gold")
            {
            
                $intlinks=plan::where('name','gold')->value('initial_links');
                $per_month=plan::where('name','gold')->value('per_month');
                
               $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
                $data = [
                    'recurring_application_charge' => [
                        'name' => 'gold',
                        'price' => 59.98,
                        'return_url' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/test?shop='.$store.'',
                        //"trial_days"=>5,
                        "test"=>"true"
                        
                    ],
                ];
                $response= Http::withHeaders($headers)->post('https://'.$store.'/admin/api/2023-10/recurring_application_charges.json',$data);
                // echo"<pre>";
                // print_r($response->json());die;
                $confirmation = $response->json()['recurring_application_charge']['confirmation_url'];
                $status=$response->json()['recurring_application_charge']['status'];
                $returnurl=$response->json()['recurring_application_charge']['return_url'];
                $decurl=$response->json()['recurring_application_charge']['decorated_return_url'];
                $responsedata=$response->json();
            
                $resp = $responsedata['recurring_application_charge'];

                $payment = payment::where('storename',$store)->first();
                $payment->storename = $store;
                $payment->confirmation=$confirmation;
                $payment->name = $resp['name'];
                $payment->start_month = $resp['billing_on'];
                $payment->store_count=$intlinks;
                $payment->per_month=$per_month;
                $payment->price = $resp['price'];
                $payment->charge_id= $resp['id'];
                $payment->status = $resp['status'];
                $payment->save();
                $data=compact('confirmation');
                return view('/url')->with($data);
            }      
    }

    public function testurl(Request $request)
    {
        
        $store=$request['shop'];
        if(payment::where('storename',$store)->exists())
        {
            $stat=payment::where('storename',$store)->first();
            $stat->status="active";
            $stat->save();
            return redirect('https://'.$store.'/admin');
        }      
    }

    public function page_create()
    {
        $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
            $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
            $data = [
                'page' => [
                    'title' => 'Outbound Links',
                    'body_html' =>"<h2>Warranty</h2>\n<p>Returns accepted if we receive items <strong>30 days after purchase</strong>.</p>"
                ],
            ];
            $response = Http::withHeaders($headers)->post('https://' . $this->shop. '/admin/api/2024-01/pages.json',$data);
             
          
    }

    public function page_template( )
    { 
       
        $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
        $array = array(
            'script_tag' => array(
                'event' => 'onload', 
                'src' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/assets/js/template.js',
                
            )
            
        );
        $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
        $response= Http::withHeaders($headers)->post('https://'.$this->shop.'/admin/api/2024-01/script_tags.json', $array);
        
          $this->ajax_data();
    
    }

    public function ajax_data(Request $request=null)
    {
        if(!$request)
        {
            $request=request();
            return ["test"=>"done"];die;
            $store=$request->store;

            $freeplandate=plan::where('name','free')->value('plan_date');
            $bronzeplandate=plan::where('name','bronze')->value('plan_date');
            $silverplandate=plan::where('name','silver')->value('plan_date');
            $goldplandate=plan::where('name','gold')->value('plan_date');
            
            $freestorelinkcount=payment::where('storename',$store)->where('start_month','>=',$freeplandate)->value('store_count');
            $prefreestorelinkcount=payment::where('storename',$store)->where('start_month','<=',$freeplandate)->value('store_count');
            
            $bronzestorelinkcount=payment::where('storename',$store)->where('start_month','>=',$bronzeplandate)->value('store_count');
            $prebronzestorelinkcount=payment::where('storename',$store)->where('start_month','<=',$bronzeplandate)->value('store_count');
   
            $silverstorelinkcount=payment::where('storename',$store)->where('start_month','>=',$silverplandate)->value('store_count');
            $presilverstorelinkcount=payment::where('storename',$store)->where('start_month','<=',$silverplandate)->value('store_count');
   
            $goldstorelinkcount=payment::where('storename',$store)->where('start_month','>=',$goldplandate)->value('store_count');
            $pregoldstorelinkcount=payment::where('storename',$store)->where('start_month','<=',$goldplandate)->value('store_count');
            $permonthcount=payment::where('storename',$store)->value('per_month');
            //  $differencecount=$storelinkcount-$permonthcount;
            $currentDateTime = Carbon::now();
            $oldmonth=payment::where('storename',$store)->value('start_month');
            $oldmonths=Carbon::parse($oldmonth);
               
            $months = $oldmonths->diffInMonths($currentDateTime);
            $plan=payment::where('storename',$store)->value('name');
          
            $stat=payment::where('storename',$store)->value('status');
            $freenumber=freelinks::where('storename',$store)->value('freelinks');
   
            $freeintlinks=plan::where('name','free')->value('initial_links');
            $freeper_month=plan::where('name','free')->value('per_month');
   
            $bronzeintlinks=plan::where('name','bronze')->value('initial_links');
            $bronzeper_month=plan::where('name','bronze')->value('per_month');
   
            $silverintlinks=plan::where('name','silver')->value('initial_links');
            $silverper_month=plan::where('name','silver')->value('per_month');
   
            $goldintlinks=plan::where('name','gold')->value('initial_links');
            $goldper_month=plan::where('name','gold')->value('per_month');
               if($plan=="free")
               {
                   $count= payment::where('name', 'free')->where('start_month','>=',$freeplandate)->update(['store_count' => $freeintlinks,'per_month'=>$freeper_month]);
                   if($oldmonth>=$freeplandate)
                   {
                       if(!freelinks::where('storename',$store)->exists())
                       {
                        $prod_data=DB::table("tbl_inbound")
                        ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                         ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                        ->where('tbl_inbound.outbound_store','=',$store)
                        ->where('tbl_inbound.status','1')
                         //    ->limit($storecount)
                         ->limit($freestorelinkcount)
                          ->get();
                        
                        return $prod_data;
                       }
                       else
                       {
                        $prod_data=DB::table("tbl_inbound")
                        ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                         ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                        ->where('tbl_inbound.outbound_store','=',$store)
                        ->where('tbl_inbound.status','1')
                         //    ->limit($storecount)
                         ->limit($freestorelinkcount+$freenumber)
                          ->get();
                        
                        return $prod_data;
                       }
                   }
                   else
                   {
                       if(!freelinks::where('storename',$store)->exists())
                       {
                        $prod_data=DB::table("tbl_inbound")
                        ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                         ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                        ->where('tbl_inbound.outbound_store','=',$store)
                        ->where('tbl_inbound.status','1')
                         //    ->limit($storecount)
                         ->limit($prefreestorelinkcount)
                          ->get();
                        
                        return $prod_data;
                       }
                       else
                       {
                        $prod_data=DB::table("tbl_inbound")
                        ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                         ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                        ->where('tbl_inbound.outbound_store','=',$store)
                        ->where('tbl_inbound.status','1')
                         //    ->limit($storecount)
                         ->limit($prefreestorelinkcount+$freenumber)
                          ->get();
                        
                        return $prod_data;
                       }
                   }
               }
               elseif($plan=="bronze"&&$stat=="active")
               {
                   $count= payment::where('name', 'bronze')->where('start_month','>=',$bronzeplandate)->update(['store_count' => $bronzeintlinks,'per_month'=>$bronzeper_month]);
                   if($oldmonth>=$bronzeplandate)
                   {
                       if(!freelinks::where('storename',$store)->exists())
                       {
                           if($months=="0")
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit($bronzestorelinkcount+$permonthcount)
                              ->get();
                            
                            return $prod_data;
                           }
                           else
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit(($bronzestorelinkcount+$permonthcount)+($months*$permonthcount))
                              ->get();
                            
                            return $prod_data;
                           }
                       }
                       else
                       {
                           if($months=="0")
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit($bronzestorelinkcount+$permonthcount+$freenumber)
                              ->get();
                            
                            return $prod_data;
                           }
                           else
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit(($bronzestorelinkcount+$freenumber+$permonthcount)+($months*$permonthcount))
                              ->get();
                            
                            return $prod_data;
                           }
                       }
                   }
                   else
                   {
                        if(!freelinks::where('storename',$store)->exists())
                        {
                            if($months=="0")
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit($prebronzestorelinkcount+$permonthcount)
                            ->get();
                            
                            return $prod_data;
                            }
                            else
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit(($prebronzestorelinkcount+$permonthcount)+($months*$permonthcount))
                            ->get();
                            
                            return $prod_data;
                            }
                        }
                        else
                        {
                            if($months=="0")
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit($prebronzestorelinkcount+$permonthcount+$freenumber)
                            ->get();
                            
                            return $prod_data;
                            }
                            else
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit(($prebronzestorelinkcount+$freenumber+$permonthcount)+($months*$permonthcount))
                            ->get();
                            
                            return $prod_data;
                            }
                        }
                   }
               }
               elseif($plan=="silver"&&$stat=="active")
               {
                   $count= payment::where('name', 'silver')->where('start_month','>=',$silverplandate)->update(['store_count' => $silverintlinks,'per_month'=>$silverper_month]);
                   if($oldmonth>=$silverplandate)
                   {
                       if(!freelinks::where('storename',$store)->exists())
                       {
                           if($months=="0")
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit($silverstorelinkcount+$permonthcount)
                              ->get();
                            
                            return $prod_data;
                           }
                           else
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit(($silverstorelinkcount+$permonthcount)+($months*$permonthcount))
                              ->get();
                            
                            return $prod_data;
                           }
                       }
                       else
                       {
                           if($months=="0")
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit($silverstorelinkcount+$permonthcount+$freenumber)
                              ->get();
                            
                            return $prod_data;
                           }
                           else
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit(($silverstorelinkcount+$freenumber+$permonthcount)+($months*$permonthcount))
                              ->get();
                            
                            return $prod_data;
                           }
                       }
                   }
                   else
                   {
                        if(!freelinks::where('storename',$store)->exists())
                        {
                            if($months=="0")
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit($presilverstorelinkcount+$permonthcount)
                            ->get();
                            
                            return $prod_data;
                            }
                            else
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit(($presilverstorelinkcount+$permonthcount)+($months*$permonthcount))
                            ->get();
                            
                            return $prod_data;
                            }
                        }
                        else
                        {
                            if($months=="0")
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit($presilverstorelinkcount+$permonthcount+$freenumber)
                            ->get();
                            
                            return $prod_data;
                            }
                            else
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit(($presilverstorelinkcount+$freenumber+$permonthcount)+($months*$permonthcount))
                            ->get();
                            
                            return $prod_data;
                            }
                        }
                   }
               }
               elseif($plan=="gold"&&$stat=="active")
               {
                   $count= payment::where('name', 'gold')->where('start_month','>=',$goldplandate)->update(['store_count' => $goldintlinks,'per_month'=>$goldper_month]);
                   if($oldmonth>=$goldplandate)
                   {
                       if(!freelinks::where('storename',$store)->exists())
                       {
                           if($months=="0")
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit($goldstorelinkcount+$permonthcount)
                              ->get();
                            
                            return $prod_data;
                           }
                           else
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit(($goldstorelinkcount+$permonthcount)+($months*$permonthcount))
                              ->get();
                            
                            return $prod_data;
                           }
                       }
                       else
                       {
                           if($months=="0")
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit($goldstorelinkcount+$permonthcount+$freenumber)
                              ->get();
                            
                            return $prod_data;
                           }
                           else
                           {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                             //    ->limit($storecount)
                             ->limit(($goldstorelinkcount+$freenumber+$permonthcount)+($months*$permonthcount))
                              ->get();
                            
                            return $prod_data;
                           }
                       }
                   }
                   else
                   {
                        if(!freelinks::where('storename',$store)->exists())
                        {
                            if($months=="0")
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit($pregoldstorelinkcount+$permonthcount)
                            ->get();
                            
                            return $prod_data;
                            }
                            else
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit(($pregoldstorelinkcount+$permonthcount)+($months*$permonthcount))
                            ->get();
                            
                            return $prod_data;
                            }
                        }
                        else
                        {
                            if($months=="0")
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit($pregoldstorelinkcount+$permonthcount+$freenumber)
                            ->get();
                            
                            return $prod_data;
                            }
                            else
                            {
                            $prod_data=DB::table("tbl_inbound")
                            ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
                            ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link",'tbl_product.image',"tbl_product.created_at","tbl_product.updated_at",'tbl_inbound.keyword')
                            ->where('tbl_inbound.outbound_store','=',$store)
                            ->where('tbl_inbound.status','1')
                            //    ->limit($storecount)
                            ->limit(($pregoldstorelinkcount+$freenumber+$permonthcount)+($months*$permonthcount))
                            ->get();
                            
                            return $prod_data;
                            }
                        }
                   }
               }
        }  
   }
         
        public function get_product(Request $request,$store)
        {
             $this->shop=$store;
            $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
            $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
            $alldata = [];
            $pageInfo = null;
           
            do {
                $response = Http::withHeaders($headers)->get('https://' . $this->shop . '/admin/api/2023-10/products.json?limit=250' . ($pageInfo ? '&page_info=' . $pageInfo : ''));
        
                $data = $response->json();
                $alldata = array_merge($alldata, $data['products']);
        
                $htmlResponse = $response->header('link');
                $pageInfo = null;
        
                // Check if "next" link exists in the response headers
                if (preg_match('/<([^>]+)>; rel="next"/', $htmlResponse, $matches)) {
                    $nextLink = $matches[1];
                    $pageInfo = parse_url($nextLink, PHP_URL_QUERY);
                    parse_str($pageInfo, $queryParams);
                    $pageInfo = isset($queryParams['page_info']) ? $queryParams['page_info'] : null;
                }
            } while ($pageInfo && $response->successful());
            
            $flag=0;
            $type="products";
            foreach($alldata as $productdata)
            {
                if(!(shopifyproducts::where('product_id',$productdata['id'])->exists()))
                {     
                    $products=new shopifyproducts();
                    $products->product_id=$productdata['id'];
                    $products->body_html=$productdata['body_html'];
                    $products->title=$productdata['title'];
                    $products->vendor=$productdata['vendor'];
                    $products->product_type=$productdata['product_type'];
                    $products->published_at=$productdata['published_at'];
                    $products->tags=$productdata['tags'];
                    $products->admin_graphql_api_id=$productdata['admin_graphql_api_id'];
                    $variantsarray=[];
                    foreach($productdata['variants'] as $variants )
                    {
                        $variantsarray[]=$variants;
                    
                    } 
                    $products->variants=json_encode($variantsarray) ;
                    $option=$productdata['options'];
                    $products->options=json_encode($option);
                    $products->handle=$productdata['handle'];
                    
                    //    $image=$productdata;
                    //    echo "<pre>";
                    //    print_r( $image);die;
                    $imagearray=[];
                    foreach($productdata['images'] as $image)
                    {
                        $imagearray[]=$image;
                        if(array_key_exists(0,$imagearray))
                        {
                        $url=$productdata['images'][0]['src'];
                        $products->image=$url;
                        }
                        else
                        {
                            continue;
                        }

                    }
                
                    $products->product_dump=json_encode($productdata);
                    $products->storename=$this->shop;
                    $products->type="product";
                    $products->link='https://'.$this->shop.'/'.$type.'/'.$productdata['handle'].'';
                    $products->save();
                }
                else
                {
                    $flag=1;
                }
                
            }
            $customMessage1 = '';
            if($flag==1){
                return redirect(route('index',['shop'=>$store,'customMessage1' => $customMessage1]));
              }
             return redirect(route('index',['shop'=>$this->shop,'customMessage1' => $customMessage1]));
        }
          
          
        //    public function get_blogs(Request $request,$store)
        //    {
              
            
           
        //         $this->shop=$store;
        //        $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
        //       $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
        //       $response= Http::withHeaders($headers)->get('https://'.$this->shop.'/admin/api/2023-07/blogs.json');
             
        //        $data=$response->json();
        //     //     echo"<pre>";
        //     //    print_r($data);
        //     //    die;
        //        $flag=0;
        //        $type="blogs";
        //        foreach($data['blogs'] as $blogdata)
        //        {
                    
                   
        //        //              echo"<pre>";
        //        // print_r($data_exist);
        //        // die;
        //        if(!(shopifyproducts::where('blog_id',$blogdata['id'])->exists()))
        //        {
                
                
        //                $blogs=new shopifyproducts();
        //                $blogs->blog_id=$blogdata['id'];
                  
        //                $blogs->title=$blogdata['title'];
                
        //                $blogs->tags=$blogdata['tags'];
        //                $blogs->admin_graphql_api_id=$blogdata['admin_graphql_api_id'];
        //                $blogs->handle=$blogdata['handle'];
                   
                   
        //            $blogs->product_dump=json_encode($blogdata);
        //            $blogs->storename=$this->shop;
        //            $blogs->type='blog';
        //            $blogs->link='https://'.$this->shop.'/'.$type.'/'.$blogdata['handle'].'';
                  
        //                $blogs->save();
        //             }
        //             else
        //             {
        //                 $flag = 1;
        //             }
                    
        //       }
        //       $customMessage2 = '';
        //       if($flag==1){
        //         return redirect(route('index',['shop'=>$store,'customMessage2' => $customMessage2]));
        //       }
        //       return redirect(route('index',['shop'=>$this->shop,'customMessage2' => $customMessage2]));
        //    }
  
        //    public function get_pages(Request $request,$store)
        //    {
              
        //      // $this->shop="appinfo.myshopify.com";
           
        //         $this->shop=$store;
        //        $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
        //       $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
        //      $response= Http::withHeaders($headers)->get('https://'.$this->shop.'/admin/api/2023-07/pages.json');
           
        //        $data=$response->json();
           
        //        $flag=0;
        //        $type="pages";
        //        foreach($data['pages'] as $pagedata)
        //        {
               
        //        if(!(shopifyproducts::where('page_id',$pagedata['id'])->exists()))
        //        {
        //                $pages=new shopifyproducts();
        //                $pages->page_id=$pagedata['id'];
                     
        //                 $pages->body_html=$pagedata['body_html'];
        //                 $pages->title=$pagedata['title'];
        //                 $pages->handle=$pagedata['handle'];
                     
                   
        //            $pages->product_dump=json_encode($pagedata);
        //            $pages->storename=$this->shop;
        //            $pages->type='page';
        //            $pages->link='https://'.$this->shop.'/'.$type.'/'.$pagedata['handle'].'';
                  
        //            $pages->save();
        //        }
        //        else
        //        {
        //         $flag = 1;
                
        //        }
        //     }
        //     $customMessage3 = '';
        //        if($flag==1){
        //         return redirect(route('index',['shop'=>$store,'customMessage3' => $customMessage3]));
        //       }
             
        //       return redirect(route('index',['shop'=>$this->shop,'customMessage3' => $customMessage3]));
        //    }
        public function appuninstall()
        {
            
            $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
            $clientid=config('app.SHOPIFY_CLIENT_ID');
          $webhookData = [
            'webhook' => [
                'topic' => 'app/uninstalled', 
               'address' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/webhook?shop='.$this->shop.'',
                'format' => 'json',
            ],
         ];
                
                $webhookResponse = Http::withHeaders([
                    'X-Shopify-Access-Token' => $access_token,
                    'X-Shopify-API-Key' => $clientid,
                        ])->post("https://$this->shop/admin/api/2023-10/webhooks.json", $webhookData);

                 
        }
        public function product_create()
        {
          
            $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
            $clientid=config('app.SHOPIFY_CLIENT_ID');
          $webhookData = [
            'webhook' => [
                'topic' => 'products/create', 
               'address' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/webhookproduct?shop='.$this->shop.'',
                'format' => 'json',
            ],
         ];
                
                $webhookResponse = Http::withHeaders([
                    'X-Shopify-Access-Token' => $access_token,
                    'X-Shopify-API-Key' => $clientid,
                        ])->post("https://$this->shop/admin/api/2023-10/webhooks.json", $webhookData);

        }
        public function product_delete()
        {
         
            $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
            $clientid=config('app.SHOPIFY_CLIENT_ID');
          $webhookData = [
            'webhook' => [
                'topic' => 'products/delete', 
               'address' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/webhookprod-del?shop='.$this->shop.'',
                'format' => 'json',
            ],
         ];
                
                $webhookResponse = Http::withHeaders([
                    'X-Shopify-Access-Token' => $access_token,
                    'X-Shopify-API-Key' => $clientid,
                        ])->post("https://$this->shop/admin/api/2023-10/webhooks.json", $webhookData);

        }
        public function product_update()
        {
           
            $access_token=shopify_app::where('storename',$this->shop)->value('access_token');
            $clientid=config('app.SHOPIFY_CLIENT_ID');
          $webhookData = [
            'webhook' => [
                'topic' => 'products/update', 
               'address' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/webhookprod-upd?shop='.$this->shop.'',
                'format' => 'json',
            ],
         ];
                
                $webhookResponse = Http::withHeaders([
                    'X-Shopify-Access-Token' => $access_token,
                    'X-Shopify-API-Key' => $clientid,
                        ])->post("https://$this->shop/admin/api/2023-10/webhooks.json", $webhookData);

        }

        public function webhook()
        {
           
           $shop = $_REQUEST['shop'];
           $data = file_get_contents("php://input");
           error_log($data ."---".$shop, 3, 'testing.log');
          
          shopify_app::where('storename',$shop)->delete();
          inboundlink::where('storename',$shop)->delete();
          shopifyproducts::where('storename',$shop)->delete();
          outboundlink::where('storename',$shop)->delete();
          keyword::where('storename',$shop)->delete();
          payment::where('storename',$shop)->delete();
          freelinks::where('storename',$shop)->delete();
        }

        public function webhook_product_create(Request $request)
        {
           
           $shop = $_REQUEST['shop'];
           $prod_id=$request['id'];
           $data = file_get_contents("php://input");
           error_log($data ."---".$shop, 3, 'product.log');
           
           $product= new shopifyproducts;
            $product->product_id=$prod_id;
            $product->storename=$shop;
            $product->title=$request['title'];
            $product->body_html=$request['body_html'];
            $product->vendor=$request['vendor'];
            $product->product_type=$request['product_type'];
            $product->published_at=$request['published_at'];
            $product->tags=$request['tags'];
            $product->admin_graphql_api_id=$request['admin_graphql_api_id'];
            $product->variants=json_encode($request['variants']);
            $product->options=json_encode($request['options']);
            if(!empty($request['images']))
            {     
               $url=$request['images'][0]['src'];
               $product->image=$url;
           }   
           else
           {
              $product->image=null;
           }
            $product->product_dump=json_encode($product);
            $product->type="Products";
            $product->save();
        
        }

        public function webhook_product_del(Request $request)
        {
           
           $shop = $_REQUEST['shop'];
           $prod_id=$request['id'];
           $data = file_get_contents("php://input");
           error_log($data ."---".$shop, 3, 'prod-del.log');
           shopifyproducts::where('product_id',$prod_id)->delete();
          
        }

        public function webhook_product_upd(Request $request)
        {
           
           $shop = $_REQUEST['shop'];
           $prod_id=$request['id'];
           $data = file_get_contents("php://input");
           error_log($data ."---".$shop, 3, 'prod-upd.log');
           $id=shopifyproducts::where('product_id',$prod_id)->value('id');
          if(shopifyproducts::where('product_id',$prod_id)->exists())
          {
                $product=shopifyproducts::find($id);
                $product->title=$request['title'];
                $product->body_html=$request['body_html'];
                $product->vendor=$request['vendor'];
                $product->product_type=$request['product_type'];
                $product->published_at=$request['published_at'];
                $product->tags=$request['tags'];
                $product->admin_graphql_api_id=$request['admin_graphql_api_id'];
                $product->variants=json_encode($request['variants']);
                $product->handle=$request['handle'];
                $product->options=json_encode($request['options']);
                if(!empty($request['images']))
                {     
                $url=$request['images'][0]['src'];
                $product->image=$url;
                }   
                else
                {
                    $product->image=null;
                }
                    $product->product_dump=json_encode($product);
                    $product->link='https://'.$shop.'/'.$product->type.'/'.$request['handle'].'';
                    $product->type="products";
                    $product->save();
          }
           else
           {
            $product= new shopifyproducts;
            $product->product_id=$prod_id;
            $product->storename=$shop;
            $product->title=$request['title'];
            $product->body_html=$request['body_html'];
            $product->vendor=$request['vendor'];
            $product->product_type=$request['product_type'];
            $product->published_at=$request['published_at'];
            $product->tags=$request['tags'];
            $product->admin_graphql_api_id=$request['admin_graphql_api_id'];
            $product->variants=json_encode($request['variants']);
            $product->options=json_encode($request['options']);
            $product->handle=$request['handle'];
            if(!empty($request['images']))
            {     
               $url=$request['images'][0]['src'];
               $product->image=$url;
           }   
           else
           {
              $product->image=null;
           }
            $product->product_dump=json_encode($product);
            $product->link='https://'.$shop.'/'.$product->type.'/'.$request['handle'].'';
            $product->type="products";
            $product->save();
           }
       }

       public function DA()
       {
       
        $store=$_POST['store'];
        $da_score=$_POST['da_score'];
        if(shopify_app::where('storename',$store)->exists())
        {
            $update=shopify_app::where('storename',$store)->first();
            $update->DA_score=$da_score;
            $update->save();
            $msg='DA has been submitted';
            return $msg;
        }
        else
        {
            $update=shopify_app::where('storename',$store)->first();
            $update->DA_score=$da_score;
            $update->save();
            $msg='DA has been submitted';
            return $msg;
        }
       
       }
    
       public function inboundlists()
       {
             $id=$_POST['id'];
              $store=$_POST['store'];
           
          if(!(inboundlink::where('inbound_id',$id))->exists())
          {
             $inboundlink= new inboundlink();
             $inboundlink->inbound_id=$id;
             $inboundlink->storename=$store;
             $inboundlink->save();
             $message="Link has been added to the list!<br>Please refresh your app once after adding it to the list";
             $productslist=DB::table("tbl_inbound")
             ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
             ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link","tbl_product.created_at","tbl_product.updated_at")
             ->where("tbl_inbound.inbound_id","=",$id)
             ->where("tbl_inbound.storename", "=", $store)
             ->get();
            $data=compact("message","productslist");
            return $data;
          }
          else
          {
          
            $customMessage = 'This link has already been added to the list';
            $data=compact("customMessage");
            return $data;
          
        }
          
       }
       public function publish(Request $request)
    {
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addMonth();

        $id=$_POST['id'];
        $store=$_POST['store'];
        $link=$_POST['link'];
        $keys=$_POST['keys'];
        $productslist=DB::table("tbl_inbound")
        ->leftJoin("tbl_product","tbl_product.id","=","tbl_inbound.inbound_id")
        ->select("tbl_product.title","tbl_product.vendor","tbl_product.id","tbl_product.status","tbl_product.tags","tbl_product.admin_graphql_api_id","tbl_product.type","tbl_product.link","tbl_product.created_at","tbl_product.updated_at")
        ->where("tbl_inbound.inbound_id","=",$id)
        ->where("tbl_inbound.storename", "=", $store)
        ->get();
        $status=shopifyproducts::where('id',$id)->value('status');
         $statusinb=inboundlink::where("inbound_id",$id)->value('status');
         $mystore=inboundlink::where("inbound_id",$id)->value('storename');
        $statuscount=inboundlink::where('storename',"!=",$store)->count();
      
         $count=shopifyproducts::where('storename',$store)->where('status','1')->count();
          $keycount=inboundlink::where('storename',$store)->select('keyword')->get()->count();
          
       
        if(payment::where('storename',$store)->exists())
        {
            $updateplan=payment::where('storename',$store)->first();
            $updateplan->end_month=$newDateTime;
            $updateplan->save();
        }
            $dbcurrent=payment::where('storename',$store)->value('start_month');
            $dbend=payment::where('storename',$store)->value('end_month');
            $plan=payment::where('storename',$store)->value('name');
            $stat=payment::where('storename',$store)->value('status');
        
                if($count<"5")
                {
            
                    if($keycount<"5")
                    {
                
                        if($keys!="")
                        {
                            $row=shopify_app::where('storename',"!=",$store)->get('storename')->shuffle();    
                            foreach($row as $rows)
                            {
                                if(inboundlink::where("outbound_store","!=","")->exists())
                                {
                                    if(!inboundlink::where('storename',$store)->where("outbound_store",$rows['storename'])->exists())
                                    {
                                        $settings=keyword::where('storename',$store)->where('keyword',$keys)->first();
                                        $settings->inbound_id=$id;  
                                        $settings->status='1';
                                        $settings->save();

                                        $inboundlink= new inboundlink();
                                        $inboundlink->inbound_id=$id;
                                        $inboundlink->storename=$store;
                                        $inboundlink->outbound_store=$rows['storename'];
                                        $inboundlink->keyword=$keys;
                                        $inboundlink->save();
                                    
                                        $access_token=shopify_app::where('storename',$store)->value('access_token');
                                        $array = array(
                                            'script_tag' => array(
                                                'event' => 'onload', 
                                                'src' => 'https://3044-38-137-23-83.ngrok-free.app/shop_app/assets/js/product.js?prodlink='.$link.'',
                                                
                                            )
                                            
                                        );
                                        $headers = array('Accept' => 'application/json', 'X-Shopify-Access-Token' => $access_token);
                                        //$response= Http::withHeaders($headers)->get('https://'.$store.'/admin/api/2023-10/script_tags.json');
                                        $response= Http::withHeaders($headers)->post('https://'.$store.'/admin/api/2024-01/script_tags.json', $array);
                                        if($statusinb!=="1")
                                        {
                                            $published=inboundlink::where("inbound_id",$id)->first();
                                            $published->status="1";
                                            $published->save();
                                        }
                                        if($status!=="1")
                                        {
                                        $published=shopifyproducts::find($id);
                                        $published->status="1";
                                        $published->save();
                                        $datas=$published->status;
                                        $success='Data has been inserted.<br>Please,refresh your app after publishing.';
                                        $data=compact('datas','link','productslist','success');
                                        return ['data'=>$data];
                                        }
                                            
                                    }
                                    else
                                    {
                                        $plan1="Wait for more participating stores.Come back later!";
                                        $data=compact('plan1');
                                        return ['data'=>$data];
                                    }
                                }
                                else
                                {
                                        $plan1="Wait for more participating stores.Come back later!";
                                        $data=compact('plan1');
                                        return ['data'=>$data];
                                }
                            }
                        } 
                        else
                        {
                            $plan1="Please submit keyword";
                            $data=compact('plan1');
                            return ['data'=>$data];
                        } 
                    }
                }
                else
                {
                $plan1="Cannot submit more links";
                $data=compact('plan1');
                return ['data'=>$data];
                }
    }
   

//         public function fetch()
//         {
//             $id=$_POST['ids'];
//             $store=$_POST['store'];
//             $datas=shopifyproducts::where('storename',$store)->get();
//             $data=compact("datas");
//             return $data;
//         }
//         public function links(){
//           //  echo"hello";die;
//             $store=$_POST['storename'];
//             $datas = shopifyproducts::where('storename', '!=', $store)
//             ->select('link','title','id')
//             // ->select('title')
//             ->get();
//             return response()->json(['data' => $datas]);
//         }
// //        
//         public function viewlinks()
//         {
//             $store=$_POST['store'];
//             $link=$_POST['link'];
//             //  $lists=DB::table("tbl_outbound")->where("outbound_link",$link)->pluck("storename")->toArray();
//              $lists=DB::table("tbl_outbound")->where("outbound_link",$link)->pluck("handle")->toArray();
//          $linklist = [];
//            foreach($lists as $list)
//            {
//             $product=shopifyproducts::where("handle",$list)->where('storename','!=',$store)->first();
//             if ($product) {
//                 $linklist[] = [
//                     'link' => $product->link,
//                     'title' => $product->title,
//                 ];
//             }
//             }
//            //   echo "<pre>";print_r($linklist);die;
//           if(isset($linklist))
//           {
//           return $linklist;
//           }
            
//         }
        public function score()
        {
            $store=$_POST['store'];
            $da=shopify_app::where("storename",$store)->value("DA_score");
            return $da;
        }
        public function keyword(Request $request)
        {  
            
             
             $store=$_POST['store'];
             $keyword=$_POST['keyword'];
            
             $settings=new keyword();
             $settings->storename=$store;
             $settings->keyword=$keyword;
             $settings->save();
             $msg="Your data has been submitted";
             return $msg;
            
          }    
    
    // public function popkey()
    // {
    //         $store=$_POST['store'];
    //         $selectedInboundId=$_POST['selectedInboundId'];
    //         //echo $selectedInboundId;die;
    //   //  $datas=keyword::where('inbound_id', $selectedInboundId)->select("keyword","id")->get();
    //     $datas=keyword::where('inbound_id', $selectedInboundId)->pluck("keyword","id")->toArray();
    //     return response()->json(['data' => $datas]);
        
    // }
        public function delete()
        {
            
        $id=$_POST['id'];
        keyword::where('id',$id)->delete();
        $message="Your entry has been deleted<br>Please refresh your app";
        return $message;
        }

        public function freelinks()
        {
            return view('freelinks');
        }

        public function freelinkssubmission(Request $request)
        {
            $validatedData = $request->validate([
                'store' => 'required',
                'number' => 'required|numeric|min:1',
            ]);
                $store=$request['store'];
                $number=$request['number'];
            
                if(!freelinks::where('storename',$store)->exists())
                {
                    $free=new freelinks();
                    $free->storename=$store;
                    $free->freelinks=$number;
                    $free->save();
                    $message="Data has been submitted";
                    $data=compact('message');
                    return redirect('/freelinks')->with($data);
                }
                else
                {
                    $message="Free links already been given";
                    $data=compact('message');
                    return redirect('/freelinks')->with($data);
                }
        }

  
    // public function insert_data(Request $request)
    // {
    //      $store = $request->store;
    //      $addition = inboundlink::where('storename', $store)->select('inbound_id', 'keyword')->distinct('inbound_id')->get();
    //     //  return $addition;die;
    //     //   $rows = inboundlink::where('status', '0')->where('outbound_store', '!=', '')->where('outbound_store',"!=",$store)->get();
    //     $rows = inboundLink::where('status', '0')
    //     ->where('outbound_store', '!=', '')
    //     ->where('outbound_store', '!=', $store)
    //     ->get();
       
    //     //  return $rows;die;
    //      $additionIndex = 0; // Counter to keep track of current index in $addition
    //          foreach ($rows as $row)
    //          {
    //             // Check if there are more records in $addition
    //             if ($additionIndex < count($addition)) {
    //                  $add = $addition[$additionIndex];

    //                  $row->storename = $store;
    //                  $row->inbound_id = $add['inbound_id'];
    //                  $row->keyword = $add['keyword'];
    //                  $row->status="1";
    //                  $row->save();

    //                 $additionIndex++; // Move to the next record in $addition
    //              }
    //          }
           
    //        return ['message' => "success"];
    // }
    
    public function insert_data(Request $request)
    {
         $row=shopify_app::select('storename')->get()->shuffle();
                foreach($row as $item)
                { 
                      if(inboundlink::where('storename',$item['storename'])->exists())
                    {
                        $addition = inboundlink::where('storename',$item['storename'])->select('inbound_id','keyword','outbound_store')->get();
                        $otherstores=shopify_app::where('storename',"!=",$item['storename'])->get();
                        foreach($otherstores as $add)
                        {
                            if(!inboundlink::where('storename',"=",$item['storename'])->where('outbound_store',$add['storename'])->exists())
                            {
                                foreach($addition as $flag)
                                {
                                 if(!inboundlink::where('storename',$item['storename'])->where('outbound_store',$add['storename'])->exists())
                                 {   
                                    $inboundlink=new inboundlink();
                                    $inboundlink->inbound_id=$flag['inbound_id'];
                                    $inboundlink->storename=$item['storename'];
                                    $inboundlink->outbound_store=$add['storename'];
                                    $inboundlink->keyword=$flag['keyword'];
                                    $inboundlink->status="1";
                                    $inboundlink->save(); 
                                 }
                                }
                                return "success";
                            }
                        }
                     }

                }
    }
}