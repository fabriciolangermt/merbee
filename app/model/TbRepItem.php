<?php


class TbRepItem extends TRecord
{
    const TABLENAME  = 'tb_rep_item';
    const PRIMARYKEY = 'id';
    const IDPOLICY   = 'serial'; // {max, serial}

    public function get_item()
    {
        
        return new TbItem($this->id_item);
    }
}
