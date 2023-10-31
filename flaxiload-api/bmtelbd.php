    $amount = $request->amount;
                $number = $request->number;
                $user_id = Auth::user()->id;
    
                // Type = prepaid = 1, postpaid = 2
                if($request->type == '1'){
                    $url = "http://bmtelbd.com/sendapi/request";
                    $type = 1;
                }
                if($request->type == '2'){
                    $url = "http://bmtelbd.com/sendapi/request";
                    $type = 2;
                }

                key = api key
                user = api login username
                
                $uniqid = uniqid();
                $post = array(
                    'user' => '',
                    'key' => '',
                    'amount' => $amount,
                    'number' => $number,
                    'service' => '64',
                    'type' => $type,
                    'id' => $uniqid
                );
    
                $headers = ['api-band: flexisoftwarebd'];  
                $header  = array($flapi_key='key', $flapi_userid='osman');
                $header2 = array('band-key: flexisoftwarebd',);
                $mheader = array_merge($header2, $header); 
                $ch = curl_init($url);
                // dd($ch);
                curl_setopt($ch, CURLOPT_HTTPHEADER,$mheader);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
                $result = curl_exec($ch);
                // dd($result);
                // return $result;
                curl_close($ch);
                $result = json_decode($result);
