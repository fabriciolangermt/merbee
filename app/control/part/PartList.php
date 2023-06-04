<?php

class PartList extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    
    // trait with onReload, onSearch, onDelete...
    use Adianti\Base\AdiantiStandardListTrait;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('unit_a');                // defines the database
        $this->setActiveRecord('TbPart');            // defines the active record
        $this->setDefaultOrder('id', 'asc');          // defines the default order
        $this->addFilterField('nome', 'like'); // add a filter field
        // $this->addFilterField('unity', '=');          // add a filter field
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Product');
        $this->form->setFormTitle('Lista de beneficiários');
        
        // create the form fields
        $description = new TEntry('nome');
        // $unit        = new TCombo('unity');
        // $unit->addItems( ['PC' => 'Pieces', 'GR' => 'Grain'] );
        
        // add a row for the filter field
        $this->form->addFields( [new TLabel('Nome')], [$description] );
        // $this->form->addFields( [new TLabel('Unit')], [$unit] );
        
        $this->form->setData( TSession::getValue('ProductList_filter_data') );
        
        $this->form->addAction( 'Buscar', new TAction([$this, 'onSearch']), 'fa:search blue');
        $this->form->addActionLink( 'Novo',  new TAction(['PartReg', 'onEdit']), 'fa:plus green');
        
        // expand button
        $this->form->addExpandButton();
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        // $this->datagrid->enablePopover('Image', "<img style='max-height: 300px' src='{photo_path}'>");
        // creates the datagrid columns
        $col_id          = new TDataGridColumn('id', 'ID', 'center', '20%');
        $col_description = new TDataGridColumn('nome', 'Nome', 'left', '40%');
        $col_stock       = new TDataGridColumn('cpf', 'CPF', 'left', '20%');
        $col_sale_price  = new TDataGridColumn('vl_sld', 'Saldo', 'right', '20%');
        
        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_description);
        $this->datagrid->addColumn($col_stock);
        $this->datagrid->addColumn($col_sale_price);
        
        // creates two datagrid actions
        $action1 = new TDataGridAction(['PartReg', 'onEdit'], ['id'=>'{id}']);
        $action2 = new TDataGridAction([$this, 'onDelete'], ['id'=>'{id}']);
        
        // add the actions to the datagrid
        $this->datagrid->addAction($action1, 'Edit', 'far:edit blue');
        $this->datagrid->addAction($action2 ,'Delete', 'far:trash-alt red');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ItemList'));
        $container->add($this->form);
        $container->add($panel = TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        $panel->getBody()->style = 'overflow-x:auto';
        parent::add($container);
    }
}