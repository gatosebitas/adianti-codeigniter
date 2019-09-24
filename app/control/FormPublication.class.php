<?php

use Adianti\Widget\Form\TDate;

/**
 * SinglePageView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Renato
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormPublication extends TPage
{
    protected $form;

    // trait with onSave, onClear, onEdit, ...
    use Adianti\Base\AdiantiStandardFormTrait;

    // trait with saveFile, saveFiles, ...
    //use Adianti\Base\AdiantiFileSaveTrait;

    function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder('form_Product');
        $this->form->setFormTitle('PUBLICACION');

        // define the database and the Active Record
        $this->setDatabase('database');
        //$this->setActiveRecord('publication');

        // create the form fields
        $id          = new TEntry('id');
        $title       = new TEntry('title');
        $description = new TEntry('description');
        $date_publicated  = new TDate('date_publicated');

        //$photo_path  = new TFile('picture');
        $media_path  = new TMultiFile('medias');

        // allow just these extensions
        //$photo_path->setAllowedExtensions( ['gif', 'png', 'jpg', 'jpeg','mp4'] );
        //$media_path->setAllowedExtensions( ['gif', 'png', 'jpg', 'jpeg'] );

        // enable progress bar, preview, and file remove actions
        //$photo_path->enableFileHandling();

        $id->setEditable(FALSE);

        // add the form fields
        $this->form->addFields([new TLabel('ID', 'red')],          [$id]);
        $this->form->addFields([new TLabel('Titulo', 'red')], [$title]);
        $this->form->addFields([new TLabel('Description', 'red')], [$description]);
        $this->form->addFields([new TLabel('Fecha de publicacion', 'red')],       [$date_publicated]);
        $this->form->addFields([new TLabel('Photo Path', 'red')],  [$media_path]);
        // $this->form->addFields( [new TLabel('Photo Path', 'red')],  [$photo_path] );

        $id->setSize('50%');

        $description->addValidation('Description', new TRequiredValidator);
        $title->addValidation('Tilte', new TRequiredValidator);


        //$photo_path->addValidation('Photo Path', new TRequiredValidator);
        $media_path->addValidation('Photo Path', new TRequiredValidator);

        // add the actions
        $this->form->addAction('Save', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addAction('Clear', new TAction([$this, 'onEdit']), 'fa:eraser red');
        $this->form->addAction('Prueba', new TAction([$this, 'prueba']), 'fa:eraser red');
        //$this->form->addActionLink( 'List', new TAction(['ProductList', 'onReload']), 'fa:table blue');

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        //$vbox->add(new TXMLBreadCrumb('menu.xml', 'ProductList'));
        $vbox->add($this->form);

        parent::add($vbox);
    }

    /**
     * Overloaded method onSave()
     * Executed whenever the user clicks at the save button
     */
    public function onSave()
    {
        try {
            TTransaction::open('database');

            // form validations
            $this->form->validate();

            // get form data
            $data   = $this->form->getData();

            // store product
            $object = new ViewPublication();
            //$object->fromArray( (array) $data);
            $object->title = $data->title;
            $object->description = $data->description;
            $object->date_publicated = $data->date_publicated;
            $object->store();

            // copy file to target folder
            $object2 = new ViewPublication();
            //$this->saveFile($object, $data, 'photo_path', 'files/images');
            //$this->saveFile($object2, $data, 'media_path', 'files/media');

            // send id back to the form
            $id_publication=$object->id;
            $data->id = $object->id;
            
            $this->form->setData($data);

            TTransaction::close();
            $this->saveMedia($id_publication);
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        } catch (Exception $e) {
            $this->form->setData($this->form->getData());
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public function saveMedia($id_publication)
    {
        $data   = $this->form->getData();
        $folder_old = 'tmp/';
        $folder_new = 'uploads/';
        try {
            TTransaction::open('database');

            // form validations
            $this->form->validate();
            $data   = $this->form->getData();

            // store product
            foreach ($data->medias as $med) {

                $partesNombre = explode('.', $med);
                $extension = end($partesNombre);
                //$extension=substr($med,-4);
                $new_name= hash('md5',$med).'.'.$extension;
                rename($folder_old.$med,$folder_new.$new_name);
                $object = new ViewMedia();
                $object->name = $med;
                $object->id_publication = $id_publication;
                $object->path=$folder_new.$new_name;
                $object->store();
            }
            
            TTransaction::close();
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        } catch (Exception $e) {
            $this->form->setData($this->form->getData());
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    
    }

    public function prueba()
    {
        $data   = $this->form->getData();
        
            foreach ($data->medias as $med) {
              
                

                $partesNombre = explode('.', $med);
                $extensionArchivo = end($partesNombre);
                echo $extensionArchivo;
                
            }
            
            
    }
}
