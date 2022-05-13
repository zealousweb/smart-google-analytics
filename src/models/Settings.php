<?php
/**
 * Smart Google Analytics plugin for Craft CMS 3.x
 *
 * Smart Google Analytics
 *
 * @link      https://www.zealousweb.com
 * @copyright Copyright (c) 2021 zealousweb
 */

namespace zealouswebcraftcms\smartgoogleanalytics\models;

use zealouswebcraftcms\smartgoogleanalytics\SmartGoogleAnalytics;

use Craft;
use craft\base\Model;

/**
 * SmartGoogleAnalytics Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    zealousweb
 * @package   SmartGoogleAnalytics
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */

    public $oauthClientId;

    public $oauthClientSecret;

    public $mapsApiKey;

    public $settings;
    
    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    
    public function rules()
    {
        return [
            [['oauthClientId'],'required','message' => 'Client Id can not be blank'],
            [['oauthClientSecret'],'required','message' => 'Client Secret can not be blank'],
            [['mapsApiKey'],'required','message' => 'Maps ApiKey can not be blank']
        ];
    }
}
