<?php
Yii::import('zii.widgets.CPortlet');

class RegisterWidget extends CPortlet{
	public $visible=true;
	public $position='main'; //main, right
	public $site_name=null;
	public $admin_email=null;
	public $client_name=null;
	
	public function init()
	{
		if($this->visible)
		{
			//ecommerce module has statekeyprefix, so on client area need 
			//that prefix in order to retrieve getState
			Yii::app()->user->setStateKeyPrefix('jagungbakar');

			if(empty($this->site_name))
				$this->site_name=Yii::app()->config->get('site_name');
			if(empty($this->admin_email))
				$this->admin_email=Yii::app()->config->get('admin_email');
			if(empty($this->client_name))
				$this->client_name=Yii::app()->config->get('site_name');
		}
	}
 
	public function run()
	{
		if($this->visible)
		{
			if(Extension::getIsInstalled(array('id'=>'ecommerce')))
	 			$this->renderContent();
		}
	}
	
	protected function renderContent()
	{
		Yii::import('application.modules.ecommerce.*');

		if($this->position=='main')
			$model = new ModClient('create');
		else
			$model = new ModClient;
		//default country
		$model->country = 'ID';

		if(isset($_GET['name']))
			$model->name = $_GET['name'];
		if(isset($_GET['email']))
			$model->email = $_GET['email'];
		$model2 = new ModClientOrder('create');
		if(isset($_POST['ModClient']))
		{
			$model->attributes=$_POST['ModClient'];
			if($this->position=='right'){
				if($model->validate()){
					$this->controller->redirect(array('/mendaftar?name='.$model->name.'&email='.$model->email));
				}
			}
			if(!empty($model->full_name)){
				$ex_name = explode(" ",$model->full_name);
				$model->first_name = $ex_name[0];
				if(count($ex_name)==1)
					$last_name = $ex_name[0];
				else{
					if(count($ex_name)>2){
						$lname = array();
						for($i=1; $i<=count($ex_name); $i++){
							$lname[] = $ex_name[$i];
						}
						$last_name = implode(" ",$lname);
					}else	
						$last_name = $ex_name[1];
				}
				$model->last_name = $last_name;
			}
			$model->gender = 'male';
			$model->salt = md5($model->generateSalt());
			$model->password = $model->hashPassword('123456',$model->salt);
			$model->type = 'personal';
			$model->client_group_id = 1;
			$model->ip = $_SERVER['REMOTE_ADDR'];
			$model->status = ModClient::UNVERIFIED;
			$model->date_entry = date(c);
			if($model->validate()){
				//for order
				$carts = array();
				if(Yii::app()->user->hasState('carts'))
					$carts = Yii::app()->user->getState('carts');
				if(count($carts)>0){
					//find the client if any
					$client = $model->findOneByEmail($model->email);
					if($client)
						$model = $client;
					else
						$model->save();
					$params = array(
							'client' => $model->attributes,
							'carts' => $carts,
							'notes' => $model2->notes
						);
					$invoice = $model2->createOrderFromCart($params);
					if($invoice){
						//send mail
						Yii::import('application.modules.email.components.*');
						if($model->status == ModClient::UNVERIFIED)
							EmailHook::onAfterClientSignUp(array('id'=>$model->id,'password'=>'123456'));
						$inv_params = array(
								'formated_number'=>$invoice->formatedNumber	
							);
						$result = array_merge($inv_params,$invoice->attributes);
						EmailHook::onAfterInvoiceIssued($result);
				
						//Yii::app()->user->setFlash('register',Yii::t('EcommerceModule.client','Thank you for your order.'));
						//$this->controller->refresh();
						Yii::app()->user->setState('terimakasih',true);
						Yii::app()->user->setState('carts',null);
						$this->controller->redirect(array('/order/terimakasih'));
					}
				}
			}
		}
		$this->render('_register',array('model'=>$model,'model2'=>$model2));
	}

	private function sendMail($data){
		//$template_email =  Yii::app()->file->set('emails/'.$data['template'].'.html', true);
		//$user_email = $template_email->contents;
		$user_email = EmailTemplate::findOneByCode($data['template'])->content;
			
		$user_email = FPMail::addHF($user_email);
		$vari = array(
					'{-tanggal-}'=>date(Yii::app()->params['emailTime']),
					'{-sitename-}'=>Yii::app()->config->get('site_name'),
					'{-logo-}'=>Yii::app()->request->hostInfo.Yii::app()->request->baseUrl.'/uploads/images/'.Yii::app()->config->get('logo'),
					'{-support-}'=>Yii::app()->config->get('admin_email'),
					'{-copyright-}'=>'Copyright &copy; '.date(Y).' '.Yii::app()->config->get('site_name').'. All rights reserved.'
		);	
		$vari = $vari+$data['variable'];
		// just send to user	
		$user_email = str_replace(array_keys($vari), array_values($vari), $user_email);
		
		$email = Yii::app()->bbmail;
		$email->setSubject($data['subject']);
		$email->setBodyHtml($user_email);
		$email->setFrom($data['mail_from'], $data['from_name']);
		$email->addTo($data['mail_to'], $data['to_name']);
        
		$email->send('sendmail', array('mailer'=>'sendmail'));
		return true;
	}
}

?>
