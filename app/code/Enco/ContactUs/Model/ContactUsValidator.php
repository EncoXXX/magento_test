<?php

namespace Enco\ContactUs\Model;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Validator\AbstractValidator;
use Zend_Validate_EmailAddress;
use Zend_Validate_NotEmpty;

class ContactUsValidator extends AbstractValidator
{
    /**
     * Not empty validator
     *
     * @var Zend_Validate_NotEmpty
     */
    protected $validatorNotEmpty;

    /**
     * Email validator
     *
     * @var Zend_Validate_EmailAddress
     */
    protected $emailValidator;

    /**
     * ContactUsValidator constructor.
     */
    public function __construct()
    {
        $this->validatorNotEmpty = new Zend_Validate_NotEmpty();

        $this->emailValidator = new Zend_Validate_EmailAddress(
            [
                'domain' => false
            ]
        );
    }

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
         * validate for edit form in admingrid (must update only status)
         * Make with "!==null" because status and id can be 0, Zend validator does not pass such design
         */
        if ($model->isAdminEdit() && $model->getStatus()!== null && $model->getId()!== null) {
            return $this->isValidEditModel($model);
        }

        $messages = $this->validateModel($model);

        $this->_addMessages($messages);

        return empty($messages);
    }

    /**
     * Validate Phone
     *
     * @param $phone
     *
     * @return bool
     */
    public function isValidPhone($phone)
    {
        /* There are no phone validator in fork from Zend Framework 1.12.16 Release,
         * so I decided to write own validator
         */
        if ($this->validatorNotEmpty->isValid($phone)) {
            $allowedChars = ['+','0','1','2','3','4','5','6','7','8','9','(',')','-'];

            $phone = str_replace(" ", "", $phone);
            if (strlen($phone)<8 || strlen($phone)>15) {
                return false;
            }
            for ($i = 0; $i < strlen($phone); $i++) {
                if (!in_array($phone[$i], $allowedChars)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Validate model for edit action
     *
     * @param $model
     *
     * @return bool
     */
    public function isValidEditModel($model)
    {
        $messages = [];

        if (intval($model->getId()) == 0) {
            $messages['invalid_id'] = __('Invalid ID');
            $this->_addMessages($messages);
        }

        return empty($messages);
    }

    /**
     * Validate model
     *
     * @param ContactUs $model
     *
     * @return array
     */
    public function validateModel(ContactUs $model)
    {
        $messages = [];

        if (!$this->validatorNotEmpty->isValid($model->getCustomerName())) { // Ломається тут коли намагаюсь дати відповідь з прев'ю
            $messages['invalid_customer_name'] = __('Enter the Name and try again.');
        }
        if (!$this->validatorNotEmpty->isValid($model->getMessage())) {
            $messages['invalid_message'] = __('Enter the message and try again.');
        }
        if (!$this->validatorNotEmpty->isValid($model->getTheme())) {
            $messages['invalid_theme'] = __('Enter the theme and try again.');
        }

        if (!$this->emailValidator->isValid($model->getEmail())) {
            $messages['invalid_email'] = __('The email address is invalid. Verify the email address and try again.');
        }
        if ($model->getCustomerId() !== null && !$this->validatorNotEmpty->isValid($model->getCustomerId())) {
            $messages['invalid_customer_id'] = __('Customer id can\'t be 0');
        }
        //Make with "!==null" because reply id can be 0, Zend validator does not pass such design
        if ($model->getReplyId()!== null && !$this->validatorNotEmpty->isValid($model->getReplyId())) {
            $messages['invalid_reply_id'] = __('Reply id can\'t be 0');
        }
        //Make with "!==null" because status can be 0, Zend validator does not pass such design
        if ($model->getStatus() !== null && !is_int($model->getStatus())) {
            $messages['invalid_status'] = __('Status must be int');
        }
        if (!$this->isValidPhone($model->getPhone())) {
            $messages['invalid_phone'] = __('Invalid phone');
        }

        return $messages;
    }
}
