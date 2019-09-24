<?php

/**
* FormArticulo Form
* @author  Renán Darío Gonzales Apaza
*/
class FormArticulo extends TPage
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
        $this->form = new TQuickForm('form_BlogArticulo');
        $this->form->class = 'tform'; // change CSS class
        $this->form = new BootstrapFormBuilder('form_BlogArticulo');
        $this->form->style = 'display: table;width:100%'; // change style
        //$this->form->setFieldsByRow(1);

        // define the form title
        $this->form->setFormTitle('BlogArticulo');

        // define the fields

        $criteria     = new TCriteria;
        $criteria->add(new TFilter('visible', '=', 'Si'));

        $idarticulo   = new TEntry('idarticulo');
        $categoria_id = new TDBCombo('categoria_id', 'database', 'BlogCategoria', 'idcategoria', 'denominacion', 'denominacion', $criteria);
        $titulo       = new TEntry('titulo');
        $slug         = new TEntry('slug');
        $fecha_visible= new TDateTime('fecha_visible');
        $image_head   = new TFile('image_head');
        $contenido    = new THtmlEditor('contenido');

        $etiqueta     = new TEntry('etiqueta');
        $visible      = new TRadioGroup('visible');

        // complete upload action
        $image_head->setCompleteAction(new TAction(array($this,'onComplete')));




        $visible->addItems(array('Si'=> 'Si','No'=> 'No'));
        $visible->setLayout('horizontal');

        $idarticulo->setSize('100%');
        $categoria_id->setSize('100%');
        $titulo->setSize('100%');
        $slug->setSize('100%');
        $image_head->setSize('100%');
        $contenido->setSize('100%');
        $etiqueta->setSize('100%');

        $etiqueta->setTip('Escriba palabras clave separado por comas ( , )');


        $etiqueta->setSize('100%');
        $categoria_id->addValidation('Categoria Id', new TRequiredValidator);
        $titulo->addValidation('Titulo', new TRequiredValidator);
        //$slug->addValidation('Imagen Mini', new TRequiredValidator);
        $image_head->addValidation('Imagen principal', new TRequiredValidator);
        $contenido->addValidation('Contenido', new TRequiredValidator);

        //$etiqueta->addValidation('Etiqueta', new TRequiredValidator);


        $this->frame = new TElement('div');
        $this->frame->id = 'photo_frame';
        //>$this->frame->style = 'width:400px;height:auto;min - height:200px;border:1px solid gray;padding:4px;';
        $this->frame->style = 'border:1px solid gray;padding:4px;';


        $this->form->addFields([new TLabel('ID')], [$idarticulo]);
        $this->form->addFields([new TLabel('Categoria')], [$categoria_id]);
        $this->form->addFields([new TLabel('Titulo')], [$titulo]);
        $this->form->addFields([new TLabel('Fecha')], [$fecha_visible]);
        //$this->form->addFields([new TLabel('Titulo SEO')], [$slug]);
        $this->form->addFields([new TLabel('Imagen principal')], [$image_head]);
        $this->form->addFields([new TLabel('')], [$this->frame]);
        $this->form->addFields([new TLabel('Contenido')], [$contenido]);
        $this->form->addFields([new TLabel('Visible')], [$visible]);

       // $this->form->addFields([new TLabel('Etiqueta')], [$etiqueta]);


        $contenido->setSize('100%', 500);

        if (!empty($idarticulo))
        {
            $idarticulo->setEditable(false);
        }

        /** samples
        * $this->form->addQuickFields('Date', array($date1, new TLabel('to'), $date2)); // side by side fields
        * $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
        * $fieldX->setSize( 100, 40 ); // set size
        **/

        // create the form actions
        $save = $this->form->addAction(_t('Save'), new TAction(array($this,'onSave')), 'fa:floppy-o');
        $new = $this->form->addAction(_t('New'), new TAction(array($this,'onClear')), 'bs:plus-sign green');
        $list = $this->form->addAction(_t('List'), new TAction(array('ListArticulo','onLoad')), 'bs:list');


        ##BOOTSTRAP##

        TSession::setValue('image_head','____none___');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);

        parent::add($container);
    }

    /**
    * On complete upload
    */
    public static function onComplete($param)
    {
        //new TMessage('info', 'Upload completed: '.$param['image_head']);
        // refresh photo_frame
        TScript::create("$('#photo_frame').html('')");
        TScript::create("$('#photo_frame').append(\"<img style='height:200px' src='tmp/{$param['image_head']}'>\");");
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

            /**
            * // Enable Debug logger for SQL operations inside the transaction
            * TTransaction::setLogger(new TLoggerSTD); // standard output
            * TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $this->form->validate(); // validate form data

            $object = (empty($data->idgrupo)) ? new BlogArticulo : new BlogArticulo($data->idarticulo, true); // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray((array )$data); // load the object with data
            $object->slug = $this->url_title($object->titulo, '-');
            $object->store(); // save the object


            if ($object instanceof BlogArticulo) {
                $rand        = rand(1, 10000);
                $source_file = 'tmp/'.$object->image_head;
                $target_file = 'uploads/' . $rand . '_' . $object->image_head;
                //$finfo = new finfo(FILEINFO_MIME_TYPE);

                // if the user uploaded a source file
                if (file_exists($source_file)) {
                    // move to the target directory
                    rename($source_file, $target_file);

                    $object->image_head = $rand . '_' . $data->image_head;

                    $icon = new Thumb();
                    $icon->loadImage('uploads/' . $object->image_head);
                    $icon->crop(370, 240, 'center');

                    $image= fopen('uploads/thumb_' . $object->image_head, 'w+');
                    if (fwrite($image, $icon->getContents()) === false)
                    {
                        unlink($image);
                        throw new Exception('No se puede crear ' . $image);
                    }
                    fclose($image);


                    $object->icon = 'thumb_' . $object->image_head;

                    /*
                    if ($object->image_head != TSession::getValue('image_head')) {
                    if (file_exists('uploads/' . TSession::getValue('image_head'))) {
                    unlink('uploads/' . TSession::getValue('image_head'));
                    }
                    if (file_exists('uploads/thumb_' . TSession::getValue('image_head'))) {
                    unlink('uploads/thumb_' . TSession::getValue('image_head'));
                    }

                    TSession::setValue('image_head', $object->image_head);
                    }
                    */
                    $object->store(); // save the object

                }
            }



            $image = new TImage('uploads/' . $object->image_head);
            $image->style = 'height:150px';
            $this->frame->add( $image );


            // get the generated idarticulo
            $data->idarticulo = $object->idarticulo;
            $data->image_head = $object->image_head;

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));
        }
        catch (exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message

            $image_head = isset($_REQUEST['image_head']) ? $_REQUEST['image_head'] : null;
            if ($image_head) {
                $source_file = 'tmp/'.$image_head;
                if (file_exists($source_file)) {
                    $image = new TImage('tmp/' . $image_head);
                }else
                {
                    $image = new TImage('uploads/' . $image_head);
                }
                $image->style = 'height:150px';
                $this->frame->add( $image );
            }



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

    /**
    * Load object to form data
    * @param $param Request
    */
    public function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                $key    = $param['key']; // get the parameter $key
                TTransaction::open('database'); // open a transaction
                $object = new BlogArticulo($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form


                $image  = new TImage('uploads/' . $object->image_head);
                $image->style = 'height:150px';
                $this->frame->add( $image );


                TTransaction::close(); // close the transaction
            } else
            {
                $this->form->clear();
            }
        }
        catch (exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }



    public function url_title($str, $separator = '-', $lowercase = false)
    {
        define('UTF8_ENABLED', false);

        if ($separator === 'dash')
        {
            $separator = '-';
        } elseif ($separator === 'underscore')
        {
            $separator = '_';
        }

        $q_separator = preg_quote($separator, '#');

        $trans       = array(
            '&.+?;'                  => '',
            '[^\w\d _-]'             => '',
            '\s+'                    => $separator,
            '(' . $q_separator . ')+'=> $separator);

        $str = strip_tags($str);
        foreach ($trans as $key => $val)
        {
            $str = preg_replace('#' . $key . '#i' . (UTF8_ENABLED ? 'u' : ''), $val, $str);
        }

        if ($lowercase === true)
        {
            $str = strtolower($str);
        }

        return $this->convert_accented_characters(trim(trim($str, $separator)));
    }

    public function convert_accented_characters($str)
    {
        $foreign_characters = array(
            '/ä|æ|ǽ/'                                                    => 'ae',
            '/ö|œ/'                                                      => 'oe',
            '/ü/'                                                        => 'ue',
            '/Ä/'                                                        => 'Ae',
            '/Ü/'                                                        => 'Ue',
            '/Ö/'                                                        => 'Oe',
            '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|Α|Ά|Ả|Ạ|Ầ|Ẫ|Ẩ|Ậ|Ằ|Ắ|Ẵ|Ẳ|Ặ|А/'        => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|α|ά|ả|ạ|ầ|ấ|ẫ|ẩ|ậ|ằ|ắ|ẵ|ẳ|ặ|а/'      => 'a',
            '/Б/'                                                        => 'B',
            '/б/'                                                        => 'b',
            '/Ç|Ć|Ĉ|Ċ|Č/'                                                => 'C',
            '/ç|ć|ĉ|ċ|č/'                                                => 'c',
            '/Д/'                                                        => 'D',
            '/д/'                                                        => 'd',
            '/Ð|Ď|Đ|Δ/'                                                  => 'Dj',
            '/ð|ď|đ|δ/'                                                  => 'dj',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Ε|Έ|Ẽ|Ẻ|Ẹ|Ề|Ế|Ễ|Ể|Ệ|Е|Э/'                => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě|έ|ε|ẽ|ẻ|ẹ|ề|ế|ễ|ể|ệ|е|э/'                => 'e',
            '/Ф/'                                                        => 'F',
            '/ф/'                                                        => 'f',
            '/Ĝ|Ğ|Ġ|Ģ|Γ|Г|Ґ/'                                            => 'G',
            '/ĝ|ğ|ġ|ģ|γ|г|ґ/'                                            => 'g',
            '/Ĥ|Ħ/'                                                      => 'H',
            '/ĥ|ħ/'                                                      => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Η|Ή|Ί|Ι|Ϊ|Ỉ|Ị|И|Ы/'                    => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|η|ή|ί|ι|ϊ|ỉ|ị|и|ы|ї/'                  => 'i',
            '/Ĵ/'                                                        => 'J',
            '/ĵ/'                                                        => 'j',
            '/Ķ|Κ|К/'                                                    => 'K',
            '/ķ|κ|к/'                                                    => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł|Λ|Л/'                                            => 'L',
            '/ĺ|ļ|ľ|ŀ|ł|λ|л/'                                            => 'l',
            '/М/'                                                        => 'M',
            '/м/'                                                        => 'm',
            '/Ñ|Ń|Ņ|Ň|Ν|Н/'                                              => 'N',
            '/ñ|ń|ņ|ň|ŉ|ν|н/'                                            => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ο|Ό|Ω|Ώ|Ỏ|Ọ|Ồ|Ố|Ỗ|Ổ|Ộ|Ờ|Ớ|Ỡ|Ở|Ợ|О/'  => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ο|ό|ω|ώ|ỏ|ọ|ồ|ố|ỗ|ổ|ộ|ờ|ớ|ỡ|ở|ợ|о/'=> 'o',
            '/П/'                                                        => 'P',
            '/п/'                                                        => 'p',
            '/Ŕ|Ŗ|Ř|Ρ|Р/'                                                => 'R',
            '/ŕ|ŗ|ř|ρ|р/'                                                => 'r',
            '/Ś|Ŝ|Ş|Ș|Š|Σ|С/'                                            => 'S',
            '/ś|ŝ|ş|ș|š|ſ|σ|ς|с/'                                        => 's',
            '/Ț|Ţ|Ť|Ŧ|τ|Т/'                                              => 'T',
            '/ț|ţ|ť|ŧ|т/'                                                => 't',
            '/Þ|þ/'                                                      => 'th',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|Ũ|Ủ|Ụ|Ừ|Ứ|Ữ|Ử|Ự|У/'          => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|υ|ύ|ϋ|ủ|ụ|ừ|ứ|ữ|ử|ự|у/'      => 'u',
            '/Ý|Ÿ|Ŷ|Υ|Ύ|Ϋ|Ỳ|Ỹ|Ỷ|Ỵ|Й/'                                    => 'Y',
            '/ý|ÿ|ŷ|ỳ|ỹ|ỷ|ỵ|й/'                                          => 'y',
            '/В/'                                                        => 'V',
            '/в/'                                                        => 'v',
            '/Ŵ/'                                                        => 'W',
            '/ŵ/'                                                        => 'w',
            '/Ź|Ż|Ž|Ζ|З/'                                                => 'Z',
            '/ź|ż|ž|ζ|з/'                                                => 'z',
            '/Æ|Ǽ/'                                                      => 'AE',
            '/ß/'                                                        => 'ss',
            '/Ĳ/'                                                        => 'IJ',
            '/ĳ/'                                                        => 'ij',
            '/Œ/'                                                        => 'OE',
            '/ƒ/'                                                        => 'f',
            '/ξ/'                                                        => 'ks',
            '/π/'                                                        => 'p',
            '/β/'                                                        => 'v',
            '/μ/'                                                        => 'm',
            '/ψ/'                                                        => 'ps',
            '/Ё/'                                                        => 'Yo',
            '/ё/'                                                        => 'yo',
            '/Є/'                                                        => 'Ye',
            '/є/'                                                        => 'ye',
            '/Ї/'                                                        => 'Yi',
            '/Ж/'                                                        => 'Zh',
            '/ж/'                                                        => 'zh',
            '/Х/'                                                        => 'Kh',
            '/х/'                                                        => 'kh',
            '/Ц/'                                                        => 'Ts',
            '/ц/'                                                        => 'ts',
            '/Ч/'                                                        => 'Ch',
            '/ч/'                                                        => 'ch',
            '/Ш/'                                                        => 'Sh',
            '/ш/'                                                        => 'sh',
            '/Щ/'                                                        => 'Shch',
            '/щ/'                                                        => 'shch',
            '/Ъ|ъ|Ь|ь/'                                                  => '',
            '/Ю/'                                                        => 'Yu',
            '/ю/'                                                        => 'yu',
            '/Я/'                                                        => 'Ya',
            '/я/'                                                        => 'ya'
        );
        $array_from = array_keys($foreign_characters);
        $array_to   = array_values($foreign_characters);

        return preg_replace($array_from, $array_to, $str);
    }
}
