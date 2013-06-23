<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __cosntruct(){

		parent::__construct();
	}


	public function index()
	{
		$this->sty->assign('baseurl',base_url());

		$this->sty->display('common/main.tpl');

	}

	public function ajax($seccion){

		$this->sty->assign('baseurl',base_url());

        if($seccion=="pag3b")
            $this->sty->assign('fotos',  $this->cargarGaleria());

		$this->sty->display('ajax/'.$seccion.'.tpl');

	}

	public function enviar_correo(){
	
	// Set SMTP Configuration
	$emailConfig = array(
		'protocol' => 'smtp',
		'smtp_host' => 'ssl://smtp.googlemail.com',
		'smtp_port' => 465,
		'smtp_user' => 'cebcwebmaster@gmail.com',
		'smtp_pass' => 'cebc1234',
	);

		$this->load->library('email');
		
		//$this->output->enable_profiler(true);

        //$this->load->library('form_validation');
		
		$email = trim($this->input->post('mail'));
		
		//$this->form_validation->set_rules('mail', 'Email incorrecto', 'trim|required|valid_email');
		
		$this->email->set_mailtype("html");

		$this->email->from($this->input->post('mail'), 'Via Web: '. $this->input->post('nombre'));
		
		$this->email->reply_to($this->input->post('mail'));
		
		$this->email->to('colegioebc@gmail.com');

		$this->email->subject($this->input->post('asunto'));
		
		$mensaje = '<html>
					<head></head>
					<body>
						<table border="1">
							<tr>
								<td>Nombre</td>
								<td>'.$this->input->post('nombre').'</td>
							</tr>
							<tr>
								<td>Mail</td>
								<td>'.$email.'</td>
							</tr>
							<tr>
								<td>Comenario</td>
								<td>'.$this->input->post('comentario').'</td>
							</tr>
						</table>
					</body>
					</html>';
					
		$this->email->message($mensaje);

		if($email == '' || !filter_var($email, FILTER_VALIDATE_EMAIL))
		{echo 'Email incorrecto'; }
		else
		
		{if($this->email->send())
			  {
			   echo 'Su mensaje ha sido enviado correctamente, lo atenderemos lo antes posible.';
			  }

			  else
			  {
			   echo 'Error, no pudo enviarse el mensaje, revise el campo email';
			  }
		  }

		//echo $this->email->print_debugger();
	}




    private function cargarGaleria(){

        $fotos = array();
        $dir_handle = opendir('images/galeria') or die("No se pudo abrir $dir_handle");
        while ($file = readdir($dir_handle)) {
            if($file == '.' || $file == '..'){
            }else{
                $fotos[] = '<img src="images/galeria/'.$file.'" longdesc="images/galeria/'.$file.'" />';
            }
        }
        closedir($dir_handle);

        return $fotos;

    }

    public function error_404(){



    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */