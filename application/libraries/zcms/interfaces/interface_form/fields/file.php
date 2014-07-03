<?php

class File extends Fields {
    
    //Files loaded from an external folder
    protected $loaded_files;
    
    //These will be used to parse variables in image actions. The first pattern matches
    //{@var_name} and will be parsed to $current_image->var_name. The second one matches
    //{#var_name} and will be parsed to $this->raw_data[0]->var_name
    protected $paterns = array('file_var' => '/\{@(\w*)\}/','data_var' => '/\{#(\w*)\}/');
    
    public function render()
    {
        $this->_basic_file();
        
        if($this->setting('link_table') && $this->raw_data)
        {
            //We have a linked outer where the images are stored we need to 
            //retrieve the values from that table
            $this->value = array();
            $db_file_entries = $this->db->select("*")
                                        ->where('rel_id', $this->raw_data[0]->id)
                                        ->get($this->setting('link_table'))
                                        ->result();
            
            foreach($db_file_entries as $file)
            {
                $index = count($this->value);
                $this->value[$index] = $file->file;
                $this->loaded_files[$index] = $file;
            }
            
        }

        if(!is_array($this->value))
            $this->value = json_decode($this->value);
        
        if(!$this->value)
            return NULL;
        
        $this->rendered .= "<table class='table table-hover span12'>
                                <tr><th colspan='2'> Filename </th></tr>";
        
        foreach($this->value as $index => $file)
        {
            if(!$this->setting('link_table'))
            {
                $this->loaded_files[$index] = new stdClass();
                $this->loaded_files[$index]->file = $file;
            }
            
            $this->rendered .= "<tr id='zcms-file-". str_replace('.', '', strtolower($file)) ."'>
                                    <td>".$file."</td><td>";

            //Adding the file controls
            if(!$this->setting('link_table'))
            {
                //We do not have a linke table only delete button is added
                if($this->setting('delete_action'))
                    $this->rendered .= "<a href='".$this->_parse_vars ($this->backend().$this->setting('delete_action'), $index)."' class='btn btn-block btn-danger'>
                                           <i class='icon-trash icon-white'></i> " . $this->translate->t("Delete") . "
                                        </a>";
            }
            else
            {
                //We check the settings to see if we need to create Edit and Delete buttons
                if($this->setting('edit_action'))
                    $this->rendered .= "<a href='".$this->_parse_vars ($this->backend().$this->setting('edit_action'), $index)."' class='btn btn-block btn-primary'>
                                           <i class='icon-cog icon-white'></i> " . $this->translate->t("Edit") . "
                                        </a>";

                if($this->setting('delete_action'))
                    $this->rendered .= "<a href='".$this->_parse_vars ($this->backend().$this->setting('delete_action'), $index)."' class='btn btn-block btn-danger'>
                                           <i class='icon-trash icon-white'></i> " . $this->translate->t("Delete") . "
                                        </a>";
            }    
            $this->rendered .= "</td></tr>";
        }
        
        $this->rendered .= "</table>";  
    }
}
