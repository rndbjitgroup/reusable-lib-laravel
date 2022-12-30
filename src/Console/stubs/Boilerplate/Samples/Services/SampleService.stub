<?php 

namespace App\Services\Samples;

use App\Enums\CmnEnum;
use App\Http\Resources\Common\CommonArrayResource;
use App\Http\Resources\Samples\SampleCollection;
use App\Http\Resources\Samples\SampleListCollection;
use App\Http\Resources\Samples\SampleResource;
use App\Repositories\Samples\SampleRepository;
use App\Traits\Common\RespondsWithHttpStatus;
use Illuminate\Http\Response;

class SampleService 
{
    use RespondsWithHttpStatus;
    /**
     * @var $sampleRepository
     */
    protected $sampleRepository;

    /**
     * SampleService constructor. 
     * 
     * @param SampleRepository $sampleRepository
     */

    public function __construct(SampleRepository $sampleRepository)
    {
        $this->sampleRepository = $sampleRepository;
    }

    public function getAll($request)
    {
        return $this->success('',  new SampleCollection($this->sampleRepository->getAll($request)));
    }

    public function list($request)
    {
        return $this->success('', new SampleListCollection($this->sampleRepository->list($request)));
    }

    /**
     * Get sample by id.
     *
     * @param $id
     * @return String
     */
    public function get($sample)
    {
        return $this->success('', new SampleResource($sample));
    }

    public function getCommon($sample)
    {
        $params['url'] = CmnEnum::BJIT_WEBSITE_URL;
        return $this->success('', new CommonArrayResource($params));
    }

    /**
     * Validate sample data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function store($request)
    {
        $result = $this->sampleRepository->store($request);
        if($result) {
            return $this->success(__('messages.crud.stored'), new SampleResource($result), Response::HTTP_CREATED);
        }
        return $this->failure( __('messages.crud.storeFailed'));
    }

     
    /**
     * Update sample data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function update($request, $sample)
    {
        $result = $this->sampleRepository->update($request, $sample);
        if($result) {
            return $this->success(__('messages.crud.updated'), new SampleResource($result));
        }  
        return $this->failure(__('messages.crud.updateFailed'));
    }
 
    /**
     * Delete sample by id.
     *
     * @param $id
     * @return String
     */
    public function destroy($sample)
    {
        $result = $this->sampleRepository->destroy($sample);
        if($result) {
            return $this->success(__('messages.crud.deleted'));
            //return $this->success(__('messages.crud.deleted'), [], Response::HTTP_NO_CONTENT);
        }
        return $this->failure(__('messages.crud.deleteFailed'));
    }

}