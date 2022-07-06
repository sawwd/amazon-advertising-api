<?php

declare(strict_types=1);

namespace PowerSrc\AmazonAdvertisingApi\Models\RequestParams;

use PowerSrc\AmazonAdvertisingApi\Enums\ReportSegment;
use PowerSrc\AmazonAdvertisingApi\Enums\ReportCreativeType;
use PowerSrc\AmazonAdvertisingApi\Enums\ReportTactic;
use PowerSrc\AmazonAdvertisingApi\Exceptions\InvalidMetricListTypeException;
use PowerSrc\AmazonAdvertisingApi\Models\Lists\ReportMetricsList;
use function get_class;
use function sprintf;

abstract class ReportParams extends RequestParams
{
    /**
     * The list of parameter names and default values.
     *
     * @var array
     */
    protected $params = [
        'segment'      => null,
        'creativeType' => null,
        'tactic'       => null,
        'reportDate'   => null,
        'metrics'      => null,
    ];

    /**
     * A list of parameter names and the name of their associated setter method.
     *
     * @var array
     */
    protected $map = [
        'segment'      => 'setSegment',
        'creativeType' => 'setCreativeType',
        'tactic'       => 'setTactic',
        'reportDate'   => 'setReportDate',
        'metrics'      => 'setMetrics',
    ];

    /**
     * A list of array parameters that should be imploded to a single string value.
     *
     * @var array
     */
    protected $filters = [
        'metrics',
    ];

    /**
     * @param ReportMetricsList $metricsList
     *
     * @throws InvalidMetricListTypeException
     *
     * @return ReportParams
     */
    public function setMetrics(ReportMetricsList $metricsList)
    {
        $metricsListClass = $this->getMetricsListType();
        if ( ! $metricsList instanceof $metricsListClass) {
            $msg = sprintf('Invalid metrics list type. Instance of `%s` provided but instance of `%s` required.', get_class($metricsList), $metricsListClass);
            throw new InvalidMetricListTypeException($msg);
        }

        $this->params['metrics'] = $metricsList;

        return $this;
    }

    /**
     * @param ReportSegment $segment
     *
     * @return ReportParams
     */
    public function setSegment(ReportSegment $segment): self
    {
        $this->params['segment'] = $segment;

        return $this;
    }

    /**
     * @param ReportCreativeType $creativeType
     *
     * @return ReportParams
     */
    public function setCreativeType(ReportCreativeType $creativeType): self
    {
        $this->params['creativeType'] = $creativeType;

        return $this;
    }

    /**
     * @param ReportTactic $tactic
     *
     * @return ReportParams
     */
    public function setTactic(ReportTactic $tactic): self
    {
        $this->params['tactic'] = $tactic;

        return $this;
    }

    /**
     * @param string $reportDate
     *
     * @return ReportParams
     */
    public function setReportDate(string $reportDate): self
    {
        $this->params['reportDate'] = $reportDate;

        return $this;
    }

    /**
     * Return the classname of the requested report's metric list type.
     *
     * @return string
     */
    abstract protected function getMetricsListType(): string;
}
