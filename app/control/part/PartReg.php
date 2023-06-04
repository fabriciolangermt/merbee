<?php

class PartReg extends TPage
{
    protected $form;
    
    // trait with saveFile, saveFiles, ...
    use Adianti\Base\AdiantiFileSaveTrait;
    
    function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Product');
        $this->form->setFormTitle('Cadastro beneficiário');
        $this->form->setClientValidation(true);
        
        // create the form fields
        $id          = new TEntry('id');
        $nome        = new TEntry('nome');
        $cpf         = new TEntry('cpf');
        $vl_sld      = new TEntry('vl_sld');
        
        
        $id->setEditable( FALSE );
        
        $vl_sld->setNumericMask(2, ',', '.', TRUE); // TRUE: process mask when editing and saving
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')],      [$id] );
        $this->form->addFields( [new TLabel('Nome')],    [$nome] );
        $this->form->addFields( [new TLabel('CPF')],     [$cpf],
                                [new TLabel('Saldo')],   [$vl_sld] );
        
        $id->setSize('50%');
        
        // $description->addValidation('Description', new TRequiredValidator);
        // $stock->addValidation('Stock', new TRequiredValidator);
        // $sale_price->addValidation('Sale Price', new TRequiredValidator);
        // $unity->addValidation('Unity', new TRequiredValidator);
        
        // add the actions
        $this->form->addAction( 'Salvar', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Limpar', new TAction([$this, 'onEdit']), 'fa:eraser red');
        $this->form->addActionLink( 'Lista', new TAction(['PartList', 'onReload']), 'fa:table blue');
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', 'ItemList'));
        $vbox->add($this->form);
        parent::add($vbox);
    }
    
    /**
     * Overloaded method onSave()
     * Executed whenever the user clicks at the save button
     */
    public function onSave()
    {
        try
        {
            TTransaction::open('unit_a');
            
            // form validations
            $this->form->validate();
            
            // get form data
            $data   = $this->form->getData();
            
            // store product
            $object = new TbPart;
            $object->fromArray( (array) $data);
            $object->store();
            
            // send id back to the form
            $data->id = $object->id;
            $this->form->setData($data);
            
            TTransaction::close();
            new TMessage('info', 'Registro salvo com sucesso');
        }
        catch (Exception $e)
        {
            $this->form->setData($this->form->getData());
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    public function onEdit($param)
    {
        try
        {
            if (isset($param['key']))
            {
                TTransaction::open('unit_a');
                $object = new TbPart( $param['key'] );
                // $object->images = ProductImage::where('product_id', '=', $param['key'])->getIndexedArray('id', 'image');
                $this->form->setData($object);
                TTransaction::close();
                return $object;
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}