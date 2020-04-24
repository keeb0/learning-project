<?php
class Model_Image extends Model
{
	public $photos_main_path = '/web/user-photos';
	public $image_type;

	function upload_image($image_dates, $name, $path)
	{
		switch ($image_dates['type']) 
		{
			case 'image/png':
				$this->image_type = 'png';
				break;
			case 'image/jpeg':
				$this->image_type = 'jpeg';
				break;
			case 'image/gif':
				$this->image_type = 'gif';
				break;
			default:
				$this->image_type = '';
				break;
		}
		if ($this->image_type)
		{
			move_uploaded_file($image_dates['tmp_name'], $path.'/'.$name.'.'.$this->image_type);
			return 1;
		}
		else
			return 0;
	}
}