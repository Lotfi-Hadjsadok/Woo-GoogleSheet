<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Aiplatform;

class GoogleCloudAiplatformV1BatchReadFeatureValuesRequestEntityTypeSpec extends \Google\Collection
{
  protected $collection_key = 'settings';
  /**
   * @var string
   */
  public $entityTypeId;
  /**
   * @var GoogleCloudAiplatformV1FeatureSelector
   */
  public $featureSelector;
  protected $featureSelectorType = GoogleCloudAiplatformV1FeatureSelector::class;
  protected $featureSelectorDataType = '';
  /**
   * @var GoogleCloudAiplatformV1DestinationFeatureSetting[]
   */
  public $settings;
  protected $settingsType = GoogleCloudAiplatformV1DestinationFeatureSetting::class;
  protected $settingsDataType = 'array';

  /**
   * @param string
   */
  public function setEntityTypeId($entityTypeId)
  {
    $this->entityTypeId = $entityTypeId;
  }
  /**
   * @return string
   */
  public function getEntityTypeId()
  {
    return $this->entityTypeId;
  }
  /**
   * @param GoogleCloudAiplatformV1FeatureSelector
   */
  public function setFeatureSelector(GoogleCloudAiplatformV1FeatureSelector $featureSelector)
  {
    $this->featureSelector = $featureSelector;
  }
  /**
   * @return GoogleCloudAiplatformV1FeatureSelector
   */
  public function getFeatureSelector()
  {
    return $this->featureSelector;
  }
  /**
   * @param GoogleCloudAiplatformV1DestinationFeatureSetting[]
   */
  public function setSettings($settings)
  {
    $this->settings = $settings;
  }
  /**
   * @return GoogleCloudAiplatformV1DestinationFeatureSetting[]
   */
  public function getSettings()
  {
    return $this->settings;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudAiplatformV1BatchReadFeatureValuesRequestEntityTypeSpec::class, 'Google_Service_Aiplatform_GoogleCloudAiplatformV1BatchReadFeatureValuesRequestEntityTypeSpec');
