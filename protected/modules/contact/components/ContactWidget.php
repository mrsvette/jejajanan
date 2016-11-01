<?php
Yii::import('zii.widgets.CPortlet');

class ContactWidget extends CPortlet{

	public $visible = true;
	public $pageSize = 3;
	public $pagination = true;
	public $subject = 'Kontak klien';
	
	public function init()
    {
        if($this->visible)
        {
 
        }
    }
 
    public function run()
    {
        if($this->visible)
        {
            $this->renderContent();
        }
    }
	
	protected function renderContent()
	{
		$model = new ModContact;
		if(isset($_POST['ModContact'])){
			$model->attributes = $_POST['ModContact'];
			$model->date_entry = date(c);
			$mail_template = Extension::getConfigByModule('contact','contact_email_template');
			$contact_db_saved = Extension::getConfigByModule('contact','contact_db_saved');
			$contact_admin_email = Extension::getConfigByModule('contact','contact_admin_email');
			if($contact_db_saved)
				$exc = $model->save();
			else
				$exc = $model->validate();
			if($exc){
				//send mail
				Yii::import('application.modules.email.models.*');
		        $data = $model->attributes;
				$email = array();
				$email = array_merge($email,$data);
		        $email['to'] = $contact_admin_email;
		        $email['to_name'] = Yii::app()->config->get('site_name');
		        $email['code']      = $mail_template;
				
				$template = new ModEmailTemplate;
		        $send = $template->template_send($email);
				//also send to client
				$client_mail_template = Extension::getConfigByModule('contact','contact_email_template_client');
				$email2 = array();
				$email2 = array_merge($email2,$data);
		        $email2['to'] = $data['email'];
		        $email2['to_name'] = $data['name'];
		        $email2['code']      = $client_mail_template;
				
		        $client_send = $template->template_send($email2);
				
				$contact_thankyou_page = Extension::getConfigByModule('contact','contact_thankyou_page');
				if($contact_thankyou_page){
					$this->controller->redirect(array('/contact/thankyou'));
				}else{
					Yii::app()->user->setFlash('contact',Yii::t('contact','Thank you for contacting us. We will respond to you as soon as possible.'));
					$this->controller->refresh();
				}
			}
		}
		$this->render(
			'_contact',
			array(
				'model' => $model,
			)
		);
	}
}

?>
