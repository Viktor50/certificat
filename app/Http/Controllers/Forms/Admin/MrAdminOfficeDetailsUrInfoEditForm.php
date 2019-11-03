<?php


namespace App\Http\Controllers\Forms\Admin;


use App\Http\Controllers\Forms\FormBase\MrFormBase;
use App\Http\Controllers\Helpers\MrBaseHelper;
use App\Http\Models\MrCountry;
use App\Http\Models\MrOffice;
use Illuminate\Http\Request;
/**
 * Форма редактирования юридических реквизитов ВО
 */
class MrAdminOfficeDetailsEditForm extends MrFormBase
{
  protected function builderForm(&$form, $id)
  {
    $office = MrOffice::loadBy($id);

    $form['CountryID'] = array(
      '#type' => 'select',
      '#title' => 'Страна',
      '#default_value' => $office->getCountry() ? $office->getCountry()->id() : 0,
      '#value' => MrCountry::SelectList(),
      '#attributes' => ['style' => 'max-width: 150px;'],
    );

    $form['URPostalCode'] = array(
      '#type' => 'textfield',
      '#title' => 'Email',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getEmail() ?: null,
    );

    $form['Email'] = array(
      '#type' => 'textfield',
      '#title' => 'Почтовый индекс',
      '#class' => ['mr-border-radius-5'],
      '#value' => $office->getURPostalCode() ?: null,
    );

    return $form;
  }

  protected static function validateForm(array $v)
  {
    parent::ValidateBase($out, $v);

    if($v['Email'])
    {
    }

    return $out;
  }

  protected static function submitForm(Request $request, int $id)
  {
    $v = $request->all();
    $errors = self::validateForm($request->all() + ['id' => $id]);
    if(count($errors))
    {
      return $errors;
    }

    parent::submitFormBase($request->all());

    $office = MrOffice::loadBy($id) ?: new MrOffice();

    $office->setCountryID($v['CountryID'] ?: null);
    $office->setURPostalCode($v['URPostalCode'] ?: null);
    $office->setEmail($v['Email'] ?: null);
    $office->save_mr();


    return;
  }
}
