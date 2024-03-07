<html>
<head>
    <title>Merchant Check Out Page</title>
</head>
<body>
<center><h1>Please do not refresh this page...</h1></center>
<form method="post" action="<?php echo \Illuminate\Support\Facades\Config::get('config_paytm.PAYTM_TXN_URL') ?>" name="f1">
    <table border="1">
        <tbody>
        @foreach($paramList as $name => $value)
            <input type="hidden" name="{{$name}}" value="{{$value}}">
        @endforeach
        <input type="hidden" name="CHECKSUMHASH" value="{{$checkSum}}">
        </tbody>
    </table>
    <script type="text/javascript">
        document.f1.submit();
    </script>
</form>
<script>
    window.intercomSettings = {
      api_base: "https://api-iam.intercom.io",
      app_id: "nbwdn606"
    };
  </script>

  <script>
  // We pre-filled your app ID in the widget URL: 'https://widget.intercom.io/widget/nbwdn606'
  (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/nbwdn606';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
  </script>
</body>
</html>
