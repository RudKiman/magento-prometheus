<?php
/**
 * Copyright 2017 www.sitewards.com
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category Sitewards
 * @package  Sitewards_Prometheus
 * @license  apache-2.0
 */

/**
 * Defines an abstract model that other metrics should implement. Takes care of fetching the metrics resource; a
 * singleton that all metrics should checkpoint to.
 */
abstract class Sitewards_Prometheus_Model_Metrics_Abstract
{
    const S_ARG_KEY_METRIC_NAME      = 'metric_name';
    const S_ARG_KEY_METRIC_HELP      = 'metric_help';
    const S_ARG_KEY_LABEL_TITLES     = 'label_titles';
    const S_ARG_KEY_METRIC_NAMESPACE = 'metric_namespace';

    const S_TYPE_GAUGE   = 'gauge';
    const S_TYPE_COUNTER = 'counter';

    /**
     * The metric type. Can be one of:
     *
     * - Gauge
     * - Counter
     *
     * @var string
     */
    protected $sMetricType = '';

    /**
     * The name of the metric. Should be a short descriptive string, of the form "foo_bar". Check out
     * https://prometheus.io/docs/practices/naming/ for details on naming metrics.
     *
     * @var string
     */
    protected $sMetricName = '';

    /**
     * A text description that indicates what the metric represents
     *
     * @var string
     */
    protected $sMetricHelp = '';

    /**
     * The library that is exposing the metrics. Use the module name; for example, "sitewards_prometheus"
     *
     * @var string
     */
    protected $sMetricNamespace = '';

    /**
     * Labels that are being applied to the metric. Check out
     * https://prometheus.io/docs/practices/naming/ for details on labels.
     *
     * @var array
     */
    protected $aLabelTitles = [];

    /**
     * Provide some safety checking around the injection of arguments around the Magento instructor
     *
     * @param array $aArgs
     *
     * @throws Sitewards_Prometheus_Exception_InvalidConstructorArguments if the arguments ars not as expected
     */
    protected function _checkArgs(array $aArgs)
    {
        $aArgKeys = [
            self::S_ARG_KEY_METRIC_NAMESPACE,
            self::S_ARG_KEY_METRIC_NAME,
            self::S_ARG_KEY_METRIC_HELP,
            self::S_ARG_KEY_LABEL_TITLES
        ];

        foreach ($aArgKeys as $sKey) {
            if (!array_key_exists($sKey, $aArgs)) {
                throw new Sitewards_Prometheus_Exception_InvalidConstructorArguments();
            }
        }
    }

    /**
     * @return Prometheus\CollectorRegistry
     */
    protected function getResource()
    {
        return Mage::getResourceSingleton('sitewards_prometheus/metrics');
    }
}
