<?php

use Adianti\Widget\Wrapper\TDBUniqueSearch;

class RepReg extends TPage
{
    protected $form;
    private $datagrid;
    private $loaded;
    
    // trait with saveFile, saveFiles, ...
    use Adianti\Base\AdiantiFileSaveTrait;
    
    function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Product');
        $this->form->setFormTitle('Distribuição de produtos');
        $this->form->setClientValidation(true);
        
        // create the form fields
        $id               = new TEntry('id');
        $id_part          = new TDBUniqueSearch('id_part', 'unit_a', 'TbPart', 'id', 'nome');
        $vl_tot           = new TEntry('vl_tot');
        $vl_sld           = new TEntry('vl_sld');
        $vl_sld_rest      = new TEntry('vl_sld_rest');
        
        
        $id->setEditable( FALSE );
        
        $vl_tot->setNumericMask(2, ',', '.', TRUE); // TRUE: process mask when editing and saving
        // $vl_prc->setNumericMask(2, ',', '.', TRUE); // TRUE: process mask when editing and saving
        
        // add the form fields
        $this->form->addFields( [new TLabel('ID')],               [$id] );
        $this->form->addFields( [new TLabel('Beneficiário')],     [$id_part] );
        // $this->form->addFields( [new TLabel('Estque')],       [$vl_qtd],
                                // [new TLabel('Preço')],  [$vl_prc] );
        
        $id->setSize('50%');

        $this->form->addContent( ['<h5>Produtos</h5><hr>'] );

        // $product_detail_unqid      = new THidden('product_detail_uniqid');
        $tb_rep_item_id            = new THidden('tb_rep_item_id');
        $tb_rep_item_id_item       = new TDBUniqueSearch('tb_rep_item_id_item', 'unit_a', 'TbItem', 'id', 'descr');
        $tb_rep_item_vl_qtd        = new TEntry('tb_rep_item_vl_qtd');
        $tb_rep_item_vl_unt        = new TEntry('tb_rep_item_vl_unt');
        $tb_rep_item_vl_tot        = new TEntry('tb_rep_item_vl_tot');

        $tb_rep_item_vl_qtd->setNumericMask(2, ',', '.', TRUE);
        $tb_rep_item_vl_unt->setNumericMask(2, ',', '.', TRUE);
        $tb_rep_item_vl_tot->setNumericMask(2, ',', '.', TRUE);

        $this->form->addFields( [ $tb_rep_item_id]);
        $this->form->addFields( [new TLabel('Produto')], [$tb_rep_item_id_item]);
        $this->form->addFields( 
            [new TLabel('Quantidade')], [$tb_rep_item_vl_qtd], 
            [new TLabel('Preço')], [$tb_rep_item_vl_unt],
            [new TLabel('Total')], [$tb_rep_item_vl_tot]);

        $add_product = TButton::create('add_product', [$this, 'onAddItem'], 'Salvar produto', 'fa:plus-circle green');
        $add_product->getAction()->setParameter('static','1');
        $this->form->addFields([], [$add_product]);

        // creates the grid for items
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->setId('tb_rep_item');
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->makeScrollable();
        $this->datagrid->setHeight( 150 );
        $this->datagrid->setMutationAction(new TAction([$this, 'onMutationAction']));
        
        // $this->datagrid->addColumn( new TDataGridColumn('id',  'ID',  'center', '10%') );
        $this->datagrid->addColumn( new TDataGridColumn('item->descr',  'Descrição',  'left',   '40%') );
        $this->datagrid->addColumn( new TDataGridColumn('vl_qtd',  'Quantidade',  'right',   '20%') );
        $this->datagrid->addColumn( new TDataGridColumn('vl_unt', 'Valor unitário', 'right',   '20%') );
        // $this->datagrid->addColumn( new TDataGridColumn('vl_tot', 'Total', 'right',   '20%') );
        $total = $this->datagrid->addColumn( new TDataGridColumn('vl_tot', 'Total', 'right',   '20%') );

        $this->datagrid->createModel();

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->getBody()->style = 'overflow-x:auto';
        $this->form->addContent( [$panel] );

        $row = $this->form->addFields( 
            [new TLabel('Total')],              [$vl_tot],
            [new TLabel('Saldo')],              [$vl_sld],
            [new TLabel('Saldo restante')],     [$vl_sld_rest],
        );
        // $row->layout = ['col-sm-10 control-label', 'col-sm-2'];

        
        // $description->addValidation('Description', new TRequiredValidator);
        // $stock->addValidation('Stock', new TRequiredValidator);
        // $sale_price->addValidation('Sale Price', new TRequiredValidator);
        // $unity->addValidation('Unity', new TRequiredValidator);
        
        // add the actions
        $this->form->addAction( 'Salvar', new TAction([$this, 'onSave']), 'fa:save green');
        $this->form->addActionLink( 'Limpar', new TAction([$this, 'onClear']), 'fa:eraser red');
        $this->form->addActionLink( 'Lista', new TAction(['RepList', 'onReload']), 'fa:table blue');
        


        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', 'RepList'));
        $vbox->add($this->form);
        // $vbox->add($panel = TPanelGroup::pack('Itens', $this->datagrid));
        // $panel->getBody()->style = 'overflow-x: auto';
        parent::add($vbox);


        $id_part->setChangeAction(new TAction([$this,'onChangePart']));
        $tb_rep_item_id_item->setChangeAction(new TAction([$this,'onChangeItem']));
        $tb_rep_item_vl_qtd->setExitAction(new TAction([$this,'onChangeVlQtd']));
        $tb_rep_item_vl_unt->setExitAction(new TAction([$this,'onChangeVlQtd']));
    }

    public static function onChangePart($param)
    {
        if (!empty($param['id_part']))
        {
            try
            {
                TTransaction::open('unit_a');

                $part = new TbPart($param['id_part']);

                $data = new stdClass();

                $data->vl_sld = $part->vl_sld;

                TForm::sendData( 'form_Product', $data, false, false );
    
    
    
    
                TTransaction::close();
            }
            catch (Exception $e)
            {
                new TMessage('error', $e->getMessage());
            }

        }
        
    }

    public static function onChangeVlQtd($param)
    {
        $data = new stdClass;

        $vl_tot = floatval($param['tb_rep_item_vl_qtd']) * floatval($param['tb_rep_item_vl_unt']);

        $data->tb_rep_item_vl_tot = number_format($vl_tot, 2, ',', '.');

        TForm::sendData( 'form_Product', $data, false, false );
    }

    public static function onChangeItem($param)
    {
        if (!empty($param['tb_rep_item_id_item']))
        {
            try
            {
                TTransaction::open('unit_a');

                $item = new TbItem($param['tb_rep_item_id_item']);

                $data = new stdClass();

                $data->tb_rep_item_vl_unt = number_format($item->vl_prc, 2, ',', '.');

                TForm::sendData( 'form_Product', $data, false, false );
    
    
                TTransaction::close();
            }
            catch (Exception $e)
            {
                new TMessage('error', $e->getMessage());
            }

        }
        
    }

    public function onAddItem($param)
    {
        try
        {
            // $this->form->validate();
            $data = $this->form->getData();
            
            // if( (! $data->product_detail_product_id) || (! $data->product_detail_amount) || (! $data->product_detail_price) )
            // {
            //     throw new Exception('The fields Product, Amount and Price are required');
            // }
            
            $uniqid = !empty($data->tb_rep_item_id) ? $data->tb_rep_item_id : uniqid();
            

            $grid_data = ['id'          => $data->tb_rep_item_id,
                          'id_item'     => $data->tb_rep_item_id_item,
                          'vl_qtd'      => $data->tb_rep_item_vl_qtd,
                          'vl_unt'      => $data->tb_rep_item_vl_unt,
                          'vl_tot'      => $data->tb_rep_item_vl_tot];

            TTransaction::open('unit_a');

            $item = new TbRepItem();
            $item->fromArray($grid_data);
            // insert row dynamically
            $row = $this->datagrid->addItem($item);
            $row->id = $uniqid;
            
            TDataGrid::replaceRowById('tb_rep_item', $uniqid, $row);

            $vl_tot = self::onMutationAction([]);

            $items = TSession::getValue('items');
            $items[$uniqid] = $item;

            TSession::setValue('items', $items);

            $data->tb_rep_item_id          = '';
            $data->tb_rep_item_id_item     = '';
            $data->tb_rep_item_vl_qtd      = '';
            $data->tb_rep_item_vl_unt      = '';
            $data->tb_rep_item_vl_tot      = '';


            $data->vl_sld_rest = $data->vl_sld - $vl_tot;
            
            // send data, do not fire change/exit events
            TForm::sendData( 'form_Product', $data, false, false );

            TTransaction::close();
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());
            new TMessage('error', $e->getMessage());
        }
    }

    public function onClear($param)
    {
        TSession::setValue('items', []);
        $this->form->clear(); // clear form
        $this->onReload(); // reload data
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
            $object = new TbRep;
            $object->id_part = $data->id_part;
            $object->vl_tot  = $data->vl_tot;
            $object->vl_sld  = $data->vl_sld;
            $object->vl_sld_rest  = $data->vl_sld_rest;
            // $object->fromArray( (array) $data);
            $object->store();

            $items = TSession::getValue('items');

            foreach ($items as $item)
            {
                $repItem = new TbRepItem();
                $repItem->id_rep = $object->id;
                $repItem->id_item = $item->id_item;
                $repItem->vl_qtd = $item->vl_qtd;
                $repItem->vl_unt = $item->vl_unt;
                $repItem->vl_tot = $item->vl_tot;

                $repItem->store();

                $tbItem  = new TbItem($item->id_item);
                $tbItem->vl_qtd -= $item->vl_qtd;
                $tbItem->store();
            }

            $part  = new TbPart($object->id_part);

            $part->vl_sld = $object->vl_sld_rest;
            $part->store();
            
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
                $object = new TbRep( $param['key'] );
                // $object->images = ProductImage::where('product_id', '=', $param['key'])->getIndexedArray('id', 'image');
                $this->form->setData($object);

                $items = TbRepItem::where('id_rep', '=', $object->id)->get();

                TSession::setValue('items', $items);

                $this->onReload([]);

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

    /**
     * Reload the datagrid with the objects from the session
     */
    function onReload($param = NULL)
    {
        try
        {
            TTransaction::open('unit_a');

            $this->datagrid->clear(); // clear datagrid
            $items = TSession::getValue('items');
            if ($items)
            {
                foreach ($items as $object)
                {
                    // add the item inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            $this->loaded = true;

            

            TTransaction::close();
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onMutationAction($param)
    {
        $total = 0;

        $items = TSession::getValue('items');

        if ($items)
        {
            foreach ($items as $row)
            {
                // echo '<pre>';var_dump($row);
                $total += floatval($row->vl_tot);
            }
        }

        $data = new stdClass();
        $data->vl_tot = $total;

        
        
        TForm::sendData( 'form_Product', $data, false, false );

        return $total;

    }

    public function onDelete($param)
    {
        // get the cart objects from session
        $items = TSession::getValue('items');
        unset($items[ $param['key'] ]); // remove the product from the array
        TSession::setValue('items', $items); // put the array back to the session
        
        // reload datagrid
        $this->onReload( func_get_arg(0) );
    }
    
    /**
     * Show the page
     */
    public function show()
    {
        if (!$this->loaded)
        {
            $this->onReload( func_get_arg(0) );
        }
        parent::show();
    }
}