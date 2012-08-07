<?php

class Form_Decorator_Composite extends Zend_Form_Decorator_Abstract
{
    public function buildInput()
    {
        $element = $this->getElement();
        $helper  = $element->helper;

        return $element->getView()->$helper(
            $element->getName(),
            $element->getValue(),
            $element->getAttribs(),
            $element->options
        );
    }

    public function buildLegend()
    {
        $element  = $this->getElement();
        $legend   = $element->getLegend();

        return '<legend>' . $legend . '</legend>';
    }

    public function buildLabel()
    {
        $element = $this->getElement();
        $label   = $element->getLabel();

        if ($translator = $element->getTranslator()) {
            $label = $translator->translate($label);
        }

        $extras = array();
        if ($element->isRequired()) {
            $extras = array('class' => 'required');
        }

        return $element->getView()->formLabel($element->getName(), $label, $extras);
    }

    public function buildErrors()
    {
        $element  = $this->getElement();
        $messages = $element->getMessages();
        if (empty($messages)) {
            return '';
        }
        return $element->getView()->formErrors($messages);
    }

    public function buildDescription()
    {
        $element = $this->getElement();
        $desc    = $element->getDescription();
        if (empty($desc)) {
            return '';
        }
        return '<aside>' . $desc . '</aside>';
    }

    public function render($content)
    {
        $element        = $this->getElement();
        $id             = $element->getId();
        $description    = $this->buildDescription();

        if ($element instanceof Zend_Form_DisplayGroup) {
            return '<fieldset id="element-' . $element->getId() . '">' . $this->buildLegend() . $content . $description . '</fieldset>';

        } else if (!$element instanceof Zend_Form_Element) {
            return $content;
        }

        if ($element->getView() === null) {
            return $content;
        }

        $helper         = $element->helper;
        $input          = $this->buildInput();
        $label          = $this->buildLabel();
        $errors         = $this->buildErrors();
        $placement      = $this->getPlacement();
        $separator      = $this->getSeparator();

        switch ($helper) {
            case 'formDivider':
                $output = '<hr id="element-' . $id . '" />';
                break;

            case 'formHeader':
                $output = '<header id="element-' . $id . '">' . $label . $description . '</header>';
                break;

            default:
                $output = '<section id="element-' . $id . '" ' . ($errors ? 'class="errors"' : '') . '>' .
                    $label . '<div>' . $input . $description . $errors . '</div>' .
                    '</section>';
        }

        switch ($placement) {
            case (self::PREPEND):
                return $output . $separator . $content;
            case (self::APPEND):
            default:
                return $content . $separator . $output;
        }
    }
}
