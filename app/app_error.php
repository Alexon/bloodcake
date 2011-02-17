<?php

class AppError extends ErrorHandler {
   
	function cannotWriteFile($params)
	{
		$this->controller->set('file', $params['file']);
		$this->_outputMessage('cannot_write_file');
	}

}