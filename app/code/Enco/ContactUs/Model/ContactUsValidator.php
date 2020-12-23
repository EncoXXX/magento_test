<?php

namespace Enco\ContactUs\Model;

use Magento\Framework\Validator\AbstractValidator;
use Zend_Validate_EmailAddress;
use Zend_Validate_NotEmpty;

class ContactUsValidator extends AbstractValidator
{

    /**
     * Is valid function
     *
     * @param ContactUs $model
     *
     * @return bool
     */
    public function isValid($model)
    {
        /**
         * Zend validator
         *
         * @var $valid Zend_Validate_NotEmpty
         */
        $valid = new Zend_Validate_NotEmpty();

        /**
         * Messages with errors
         *
         * @var array $messages
         */
        $messages = [];

        /**
         * Email validator
         *
         * @var Zend_Validate_EmailAddress  $emailValidator
         */
        $emailValidator = new Zend_Validate_EmailAddress();

        /**
         * validate for edit form in admingrid (must update only status)
         * Make with "!==null" because status and id can be 0, Zend validator does not pass such design
         */
        if (count($model->getData()) == 2 && $model->getStatus()!== null && $model->getId()!== null) {
            if (!is_int($model->getStatus())) {
                $messages['invalid_status'] = (__('Status must be int'));
            }
            $id = $model->getId();

            if(intval($id) == 0){
                $id = -1;
            }
            if($id == '0'){
                $id = 0;
            }

            if ($id == -1) {
                $messages['invalid_id'] = (__('Invalid ID'));
            }
            $this->_addMessages($messages);
            return empty($messages);
        }

        if (!$valid->isValid($model->getCustomerName())) {
            $messages['invalid_customer_name'] = (__('Enter the Name and try again.'));
        }
        if (!$valid->isValid($model->getMessage())) {
            $messages['invalid_message'] = (__('Enter the message and try again.'));
        }
        if (!$valid->isValid($model->getTheme())) {
            $messages['invalid_theme'] = (__('Enter the theme and try again.'));
        }

        if (!$emailValidator->isValid($model->getEmail())) {
            $messages['invalid_email'] = (__('The email address is invalid. Verify the email address and try again.'));
        }
        if ($model->getCustomerId() !== null && !$valid->isValid($model->getCustomerId())) {
            $messages['invalid_customer_id'] = (__('Customer id can\'t be 0'));
        }
        //Make with "!==null" because reply id can be 0, Zend validator does not pass such design
        if ($model->getReplyId()!== null && !$valid->isValid($model->getReplyId())) {
            $messages['invalid_reply_id'] = (__('Reply id can\'t be 0'));
        }
        //Make with "!==null" because status can be 0, Zend validator does not pass such design
        if ($model->getStatus() !== null && !is_int($model->getStatus())) {
            $messages['invalid_status'] = (__('Status must be int'));
        }

        /* There are no phone validator in fork from Zend Framework 1.12.16 Release,
         * so I decided to write own validator
         */
        if ($valid->isValid($model->getPhone())) {
            $allowedChars = ['+','0','1','2','3','4','5','6','7','8','9','(',')','-'];
            $phone = $model->getPhone();
            $phone = str_replace(" ", "", $phone);
            if (strlen($phone)<8 || strlen($phone)>15) {
                $messages['invalid_phone'] = (__('Invalid phone'));
            }
            for ($i = 0; $i < strlen($phone); $i++) {
                if (!in_array($phone[$i], $allowedChars)) {
                    $messages['invalid_phone'] = (__('Invalid phone'));
                    break;
                }
            }
        }

        $this->_addMessages($messages);

        return empty($messages);
    }
}
