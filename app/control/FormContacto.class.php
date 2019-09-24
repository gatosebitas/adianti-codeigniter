<?php

/**
 * FormContacto Form
 * @author  Renán Darío Gonzales Apaza
 */
class FormContacto extends TPage
{
    protected $form; // form

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct($param)
    {
        parent::__construct();

        // creates the form
        $this->form = new TQuickForm('form_WebMessage');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormBuilder('form_WebMessage');
        $this->form->style = 'display: table;width:100%'; // change style
        //$this->form->setFieldsByRow(1);

        // define the form title
        $this->form->setFormTitle('Contacto');

        // define the fields
        $subject = new TEntry('subject');
        $name = new TEntry('name');
        $phone = new TEntry('phone');
        $email = new TEntry('email');
        $message = new TText('message');


        $subject->setSize('100%');
        $name->setSize('100%');
        $phone->setSize('100%');
        $email->setSize('100%');
        $message->setSize('100%');


        $subject->addValidation('Asunto', new TRequiredValidator);
        $name->addValidation('Nombres y Apellidos', new TRequiredValidator);
        $email->addValidation('Email', new TEmailValidator);
        $message->addValidation('Mensaje', new TRequiredValidator);


        $this->form->addFields([new TLabel('Asunto')], [$subject]);
        $this->form->addFields([new TLabel('Nombres y Apellidos')], [$name]);
        $this->form->addFields([new TLabel('Teléfono')], [$phone]);
        $this->form->addFields([new TLabel('Email')], [$email]);
        $this->form->addFields([new TLabel('Mensaje')], [$message]);


        if (!empty($id))
        {
            $id->setEditable(false);
        }

        /** samples
         * $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
         * $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         * $fieldX->setSize( 100, 40 ); // set size
         **/

        // create the form actions
        $save = $this->form->addAction('Enviar mensaje', new TAction(array($this, 'onSave')), 'fa:send');
        $new = $this->form->addAction('Limpiar', new TAction(array($this, 'onClear')), 'bs:plus-sign green');
        //$list = $this->form->addAction(_t('List'), new TAction(array($this, 'onLoad')), 'bs:plus-sign green');


        ##BOOTSTRAP##

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);

        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave($param)
    {
        try
        {
            TTransaction::open('database'); // open a transaction

            $this->form->validate(); // validate form data

            $object = (empty($data->idgrupo)) ? new WebMessage : new WebMessage($data->id, true); // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray((array )$data); // load the object with data
            $object->dt_message = date('Y-m-d H:i:s');
            $object->checked = 'N';

            $object->mensaje_tipo = 'Recibido';

            $object->store(); // save the object

            // get the generated id
            $data->id = $object->id;


            TTransaction::open('permission');

            $preferences = SystemPreference::getAllPreferences();
            if ($preferences)
            {
                //https://myaccount.google.com/lesssecureapps
                $mail = new TMail;
                $mail->setFrom($data->email);
                $mail->setSubject($data->subject);
                $mail->setHtmlBody($data->message);
                $mail->addAddress($preferences['smtp_user'], 'test');
                $mail->SetUseSmtp();
                $mail->SetSmtpHost($preferences['smtp_host'], $preferences['smtp_port']);
                $mail->SetSmtpUser($preferences['smtp_user'], $preferences['smtp_pass']);
                $mail->setReplyTo($data->email);
                //$mail->send();
            }

            TTransaction::close();


            $this->form->clear();
            TTransaction::close(); // close the transaction

            new TMessage('info', 'Mensaje enviado. Gracias');
        }
        catch (exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData($this->form->getData()); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }


    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear($param)
    {
        $this->form->clear();
    }

}
