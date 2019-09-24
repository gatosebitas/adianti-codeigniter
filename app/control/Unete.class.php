<?php

/**
* FormContacto Form
* @author  Renán Darío Gonzales Apaza
*/
class Unete extends TPage
{
    protected $form; // form

    /**
    * Constructor method
    */
    public function __construct()
    {
        parent::__construct();
    
        try
        {

            $full_name    = new TEntry('full_name');
            $email        = new TEntry('email');
            $phone_number = new TEntry('phone_number');
            $state        = new TCombo('state');
            $gender       = new TCombo('gender');
            $quiero       = new TCheckGroup('quiero[]');

            $button       = new TButton('sus');
            $accion       = new TAction(array($this,'enviar'));
            $button->title = "Suscribirme";
            $button->class = "contact100-form-btn";
            $button->setAction($accion,'Suscribirme');


            $items = array();
            $items['1'] = 'dist 1';
            $items['2'] = 'dist 2';
            $items['3'] = 'dist 3';
            $items['4'] = 'dist 4';
            $items['5'] = 'dist 5';

            $voluntario = array();
            $voluntario['Voluntario'] = '.';




            $generos = array();
            $generos['Masculino'] = 'Masculino';
            $generos['Femenino'] = 'Femenino';
            $generos['Otro'] = 'Otro';

            $full_name->title = 'Ingrese su nombre completo';
            $full_name->class = 'input100';
            $full_name->id = 'full_name';
            $full_name->placeholder = 'Nombre completo';

            $email->title = 'Ingrese su correo electrónico';
            $email->class = 'input100';
            $email->id = 'email';
            $email->placeholder = 'correo@ejemplo.com';

            $phone_number->title = 'Ingrese su número telefónico';
            $phone_number->class = 'input100';
            $phone_number->id = 'phone_number';
            $phone_number->placeholder = 'Tu número telefónico';

            $state->title = 'Seleccione su distrito de residencia';
            $state->class = "js-select2";
            $state->addItems($items);

            $gender->title = 'Seleccione un género';
            $gender->class = "js-select2";
            $gender->id = "gender";
            $gender->addItems($generos);

            $quiero->addItems($voluntario);
            $quiero->setLayout('horizont');
            $quiero->title = "Quiero ser voluntario";
            $quiero->id = "cb-1";
            $quiero->class = "class-cb-actividad";









            $div1 = new TElement('div');
            $div1->class = 'container-contact100';


            $this->form = new TQuickForm('f1');
            $this->form->class = 'contact100-form validate-form';
            $div1->add($this->form);



            $span = new TElement('span');
            $span->class = 'contact100-form-title';
            $span->add('Únete al cambio, ¡Registrate!');
            $this->form->add($span);

            $span = new TElement('span');
            $span->class = 'contact100-form-oblig';
            $span->add('(*) Campo obligatorio');
            $this->form->add($span);

            $label = new TElement('label');
            $label->title = 'Nombre completo';
            $label->for = 'full_name';
            $label->class = 'contact100-form-campos';
            $label->add('*Nombre completo:');

            $span = new TElement('span');
            $span->id = 'spMsj1';
            $span->class = 'contact100-form-error';

            $label->add($span);

            $this->form->add($label);

            $div = new TElement('div');
            $div->id = 'divName';
            $div->class = 'wrap-input100 bg1';
            $div->add($full_name);
            $this->form->add($div);






            $div = new TElement('div');
            $div->class = 'rs1-wrap-input100';

            $label = new TElement('label');
            $label->title = 'Correo electrónico';
            $label->for = 'email';
            $label->class = 'contact100-form-campos padTop';
            $label->add('*Correo electrónico:');

            $span = new TElement('span');
            $span->id = 'spMsj2';
            $span->class = 'contact100-form-error';
            $label->add($span);

            $div->add($label);

            $div2 = new TElement('div');
            $div2->id = 'divEmail';
            $div2->class = 'wrap-input100 bg1';
            $div2->add($email);

            $div->add($div2);
            $this->form->add($div);






            $div = new TElement('div');
            $div->class = 'rs1-wrap-input100';

            $label = new TElement('label');
            $label->title = 'Número telefónico';
            $label->for = 'phone_number';
            $label->class = 'contact100-form-campos padTop';
            $label->add('*Número telefónico:');

            $span = new TElement('span');
            $span->id = 'spMsj3';
            $span->class = 'contact100-form-error';
            $label->add($span);

            $div->add($label);

            $div2 = new TElement('div');
            $div2->id = 'divTel';
            $div2->class = 'wrap-input100 bg1';
            $_data = 'data-validate';
            $div2->$_data = 'Ingrese su número telefónico';
            $div2->add($phone_number);

            $div->add($div2);
            $this->form->add($div);





            $div   = new TElement('div');
            $div->class = 'rs1-wrap-input100';
            $label = new TElement('label');
            $label->title = 'Seleccione su estado de residencia';
            $label->class = 'contact100-form-campos padTop';
            $label->add('Distrito de residencia:');
            $div->add($label);
            $div2 = new TElement('div');
            $div2->class = 'wrap-input100 bg1';
            $div2->add($state);
            $div->add($div2);
            $this->form->add($div);









            $div = new TElement('div');
            $div->class = 'rs1-wrap-input100';

            $label = new TElement('label');
            $label->title = 'Seleccione su estado de residencia';
            $label->class = 'contact100-form-campos padTop';
            $label->add('Género:');

            $div->add($label);

            $div2 = new TElement('div');
            $div2->class = 'wrap-input100 bg1';
            $div2->add($gender);

            $div->add($div2);
            $this->form->add($div);




            $div = new TElement('div');
            $div->class = 'wrap-input101 rs1-wrap-input101';
            $div->style = "display:inline-block";

            $div2 = new TElement('div');
            $div2->style = "display:inline-block";

            $label = new TElement('label');
            $label->title = "Quiero ser voluntario";
            $label->id = "label-chb";
            $label->class = "contact100-form-checkbox-text";
            $label->add($quiero);
            $label->add('Quiero ser voluntario');

            $div2->add($label);
            $div->add($div2);
            $this->form->add($div);


            $div = new TElement('div');
            $div->class = "container-contact100-form-btn";

            $span = new TElement('span');
            $i    = new TElement('i');
            $i->class = "fa fa-long-arrow-right m-l-7";
            $_data = 'aria-hidden';
            $i->$_data = "true";
            $span->add($i);

            $button->add($span);

            $div->add($button);
            $this->form->add($div);


            $this->form->setFields(array($full_name,$email,$state,$gender,$phone_number,$button));

            parent::add($div1);
            // load the styles
            TPage::include_css('app/templates/front1/css/main3.css');
            TPage::include_css('app/templates/front1/css/main2.css');

        }
        catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }


    /**
    * Save form data
    * @param $param Request
    */
    public function enviar( $param )
    {
        try
        {
            TTransaction::open('database'); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $this->form->validate(); // validate form data
            $data   = $this->form->getData(); // get form data as array

            $object = (empty($data->idgrupo)) ? new Interesado : new Interesado($data->id, true); // create an empty object
           
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object

            // get the generated id
            $data->id = $object->id;

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
    * Clear form data
    * @param $param Request
    */
    public function onClear( $param )
    {
        $this->form->clear();
    }



}