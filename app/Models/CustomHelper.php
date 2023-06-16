<?php

namespace App\Models;

use Illuminate\Support\Facades\Route;

class CustomHelper
{

  private const YEAR_FOUNDED = 2021;
  public const MAX_TICKETS = 8;


  public function displayYear() 
  {

    $currentYear = now()->year;

    return self::YEAR_FOUNDED === $currentYear ? self::YEAR_FOUNDED : self::YEAR_FOUNDED . '-' . $currentYear;
  }
  public function activeLink($link) :string
  {

    return Route::current()->getName() === $link ? 'active' : '';
  }

  public function getStorageImage(string $image) :string
  {
    return asset('storage/images/' . $image);
  }

  public function getPublicImage(string $image) :string
  {
    return asset('images/' . $image);
  }


    public static function formatTime($time): string
    {
        return date('g:i A', strtotime($time));
    }


    public function formatMoney($amount){
        return'£'.number_format((float)$amount, 2, '.', '');
    }

    public static function getAdultSupervisionIcon(): string
    {
        return ' <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
        <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
        <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
      </svg>
         This ride requires Adult supervision';

    }






  public function breadcrumb($title) :string
  {
    return
      '<nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active text-capitalize" aria-current="page">' . $title . '</li>
        </ol>
      </nav>';
  }


    public function breadcrumbSub($title, $sub, $link)
    {
        return
            '<nav style="--bs-breadcrumb-divider: \'>\';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
           <li class="breadcrumb-item"><a href=' . $link . '>{' . $sub . '</a></li>

          <li class="breadcrumb-item active text-capitalize" aria-current="page">' . $title . '</li>
        </ol>
      </nav>';
    }

  private static function getMessageIcon($messageType) :string
  {
    return match ($messageType)
    {
      'success' => 'check-circle-fill',
      'danger' => 'exclamation-triangle-fill',
      default => 'info-fill',
    };

  }
  public static function  getPasswordSalt() : string{
      return 'ijdb';

  }



    public static function setErrorMessage($message) {
        return [
            'message' => $message,
            'type' => 'danger',
            'icon' => CustomHelper::getMessageIcon('danger')


        ];

    }



    public static function setError($message) {
        return
            '<div class="alert alert-danger" role="alert">
                    ' . $message . '
              
            </div>';

    }


    public static function setWarningMessage($message) {
        return [
            'message' => $message,
            'type' => 'warning',
            'icon' => CustomHelper::getMessageIcon('danger')
        ];

    }


    public static function setSuccessMessage($message) {
        return [
            'message' => $message,
            'type' => 'success',
            'icon' => CustomHelper::getMessageIcon('success')
        ];

    }

    static function snippet($str)
    {
        return substr($str, 0, 100).'...';
    }

    public static function formatDate($date) {
        return date('D d M Y', strtotime($date));
    }
    public static function getRequiredFieldMessage() {
        return '<p class="text-muted mt-3">All required fields are marked with <small class="text-danger">*</small></p>';
    }
}
