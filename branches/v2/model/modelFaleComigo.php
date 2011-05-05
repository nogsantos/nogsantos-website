<?php
/**
 * Descrição: Classe fale comigo, envio de mensagem através do mime
 */
class FaleComigo{
    private $nomeEmpresa;
    private $contato;
    private $email;
    private $mensagem;
    private $data;

    public function setNomeEmpresa($nomeEmpresa){
        $this->nomeEmpresa = $nomeEmpresa;
    }
    public function getNomeEmpresa(){
        return $this->nomeEmpresa;
    }
    public function setContato($contato){
        $this->contato = $contato;
    }
    public function getContato(){
        return $this->contato;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setMensagem($mensagem){
        $this->mensagem = $mensagem;
    }
    public function getMensagem(){
        return $this->mensagem;
    }
    public function setData($data){
        $this->data = $data;
    }
    public function getData(){
        return $this->data;
    }
    /**
     * Descrição: Enviando a mensagem.
     */
    public function enviarMensagem(){
        $mail = new htmlMimeMail();
	$mail->setFrom("<{$this->getEmail()}>");
	$mail->setSubject("Contato Site");
	$sMensagem = " Contato pelo site:<br/>
                       <br/>Nome / Empresa: {$this->getNomeEmpresa()}
                       <br/>Data da Solicitação: {$this->getData()}
                       <br/>Contato: {$this->getContato()}
                       <br/>Email: {$this->getEmail()}
                       <br/>Mensagem: {$this->getMensagem()}";
	$mail->setHtml($sMensagem);
	if($mail->send(array("fabricio@nogsantos.com.br"))){
            $mailResp = new htmlMimeMail();
            $mailResp->setFrom("<fabricio@nogsantos.com.br>");
            $mailResp->setSubject("Contato nogsantos.com.br");
            $sMensagemResp = " <br/>Olá {$this->getNomeEmpresa()}!<br />Agradeço seu contato, retornarei assim que possível.<br/>
                               <br/>Data: {$this->getData()}
                               <br/>Contato: {$this->getContato()}
                               <br/>Email: {$this->getEmail()}
                               <br/>Mensagem: {$this->getMensagem()}";
            $mailResp->setHtml($sMensagemResp);
            $mailResp->send(array("{$this->getEmail()}"));
            return true;
        }else{
            return false;
        }
    }
}