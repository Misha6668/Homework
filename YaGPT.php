<?php

	class YAGPT
	{
		//public $IAMToken; //private
		//private $OAToken;
		private $APIKey; //private
		private $FolderID;

		private $url;
		private $c;
		private $hdr;  //private
		private $message;
		public $result_message; //private
		
		//private $filename_token_oauth;
		//private $filename_token_iam; 
		private $filename_api_key;
		private $filename_folder_id;

		public $result;
		
		public function __construct()
		{
			$this->url='https://llm.api.cloud.yandex.net/foundationModels/v1/completion';
			$this->c=curl_init($this->url);
			
			$this->filename_api_key='../ai/YaGPT/tokens/APIKey';
			$this->filename_folder_id='../ai/YaGPT/tokens/FolderID';
			//$this->filename_token_iam='../tokens/IAMToken';
			//$this->filename_token_oauth='../tokens/OAuth';
		}
		/*
		public  function updateIAMToken()
		{
			$this->getOAuthToken();  //get OAuth from file
			
			$query=array('yandexPassportOauthToken'=>$this->OAToken);
			
			$this->changeUrl('https://iam.api.cloud.yandex.net/iam/v1/tokens');
			$json_encoded=json_encode($query);
			$this->message=$json_encoded;
			
			try
			{
				$this->initConnection(false); //without header
				$this->proceedResult();
				if(isset($this->result['iamToken']))
				{
					$this->IAMToken=$this->result['iamToken'];
					$this->saveIAMToken();
				}
				else
					$this->IAMToken='Error';
				
			}
			catch(Exception $e)
			{
				throw $e;
			}
		}
		*/
		/*
		public function getIAMToken() //private
		{
			$IAMToken=file_get_contents($this->filename_token_iam);
			if($IAMToken<0)
				throw new Exception('Error opening file');
			else
				$this->IAMToken=$IAMToken;
		}
		*/
		/*
		private function getOAuthToken()
		{
			$OAToken=file_get_contents($this->filename_token_oauth);
			
			$this->OAToken=$OAToken;
		}
		*/
		/*
		private function saveIAMToken()
		{
			file_put_contents($this->filename_token_iam,$this->IAMToken);
			//echo 'IAMToken';
		}
		*/
		
		private function getAPIKey() //private
		{
			$APIKey=file_get_contents($this->filename_api_key);
			if($APIKey==false)
				throw new Exception('Файл не найден');
			
			$this->APIKey=$APIKey;
		}
		private function getFolderID()
		{
			$FolderID=file_get_contents($this->filename_folder_id);
			if($FolderID ==false)
				throw new Exception('Файл не найден');
			$this->FolderID=$FolderID;
		}
		
		private function changeUrl($url)
		{
			$this->url=$url;
			$this->c=curl_init($this->url);
		}
		private function buildQuery($msg)
		{
			$prompt=array('modelUri'=>'gpt://'.$this->FolderID.'/yandexgpt/latest','completionOptions'=>array("stream"=>False,
			"temperature"=> 0.6,
			"maxTokens"=> "2000"),
			'messages'=>array(
				array(
				'role'=>'user',
				'text'=>$msg)
			));
			return $prompt;
		}
		private function buildHeader() //private
		{
			$header=['Content-Type:application/json','Authorization: Api-Key '.$this->APIKey];
			$this->hdr=$header;
		}
		private function initConnection($headerPresent)
		{
			if($headerPresent)
				curl_setopt_array($this->c,array(CURLOPT_POST=>TRUE,CURLOPT_RETURNTRANSFER=>TRUE, CURLOPT_HTTPHEADER=>$this->hdr,CURLOPT_POSTFIELDS=>$this->message));	
			else
				curl_setopt_array($this->c,array(CURLOPT_POST=>TRUE,CURLOPT_RETURNTRANSFER=>TRUE,CURLOPT_POSTFIELDS=>$this->message));
			
			$this->result_message=curl_exec($this->c);
			if($this->result_message==false)
				throw new Exception('Error connect');
		}
		private function proceedResult()
		{
			$json_decoded=json_decode($this->result_message,true);
			$this->result=$json_decoded;
		}
		
		public function queryYAGPT($msg)
		{
			try
			{
				$this->getFolderID();
				$this->getAPIKey();//$this->getIAMToken();
				$this->buildHeader();
				
				$msg=$this->buildQuery($msg);
			
				$json_encoded=json_encode($msg);
				$this->message=$json_encoded;
				$this->initConnection(true);
				
				$this->proceedResult();
				//$this->result=$this->result_message;
				
				
				if(isset($this->result['error'])) //print error
					throw new Exception($this->result['error']['message']);	
				else
				{
					$msg=null;
					if(isset($this->result['result']['alternatives'][0]['message']['text']))
						$this->result=$this->result['result']['alternatives'][0]['message']['text'];
					
					else
						$msg='Error';
				}
			}
			
			catch(Exception $e)
			{
				throw  $e;
			}
	}
			//$result=json_decode($json_decoded,true);
			
	}
			
		
	
	/*
	try
	{
		$yagpt=new YAGPT();
		
		$yagpt->queryYAGPT('Привет как дела');
		echo $yagpt->result;
		
		//$yagpt->updateIAMToken();
		//$yagpt->getIAMToken();
		//echo $yagpt->IAMToken;
	}
	catch(Exception $e)
	{
		echo $e;
	}
	
	*/
?>	