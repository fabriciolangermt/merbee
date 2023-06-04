<?php


class TbRep extends TRecord
{
    const TABLENAME  = 'tb_rep';
    const PRIMARYKEY = 'id';
    const IDPOLICY   = 'serial'; // {max, serial}

    public function get_part()
    {
        return new TbPart($this->id_part);
    }
}
