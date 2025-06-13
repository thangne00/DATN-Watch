<?php

namespace App\Http\Controllers\Backend\Attribute;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\AttributeServiceInterface  as AttributeService;
use App\Repositories\Interfaces\AttributeRepositoryInterface  as AttributeRepository;
use App\Http\Requests\Attribute\StoreAttributeRequest;
use App\Http\Requests\Attribute\UpdateAttributeRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;

class AttributeController extends Controller
{
    protected $attributeService;
    protected $attributeRepository;
    protected $languageRepository;
    protected $language;

    public function __construct(
        AttributeService $attributeService,
        AttributeRepository $attributeRepository,
    ){
        $this->middleware(function($request, $next){
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });

        $this->attributeService = $attributeService;
        $this->attributeRepository = $attributeRepository;
        $this->initialize();
        
    }

    private function initialize(){
        $this->nestedset = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    } 

    public function index(Request $request){
        $this->authorize('modules', 'attribute.index');
        $attributes = $this->attributeService->paginate($request, $this->language);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Attribute'
        ];
        $config['seo'] = __('messages.attribute');
        $template = 'backend.attribute.attribute.index';
        $dropdown  = $this->nestedset->Dropdown();
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'attributes'
        ));
    }

    public function create(){
        $this->authorize('modules', 'attribute.create');
        $config = $this->configData();
        $config['seo'] = __('messages.attribute');
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'backend.attribute.attribute.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
        ));
    }

    public function store(StoreAttributeRequest $request){
        if($this->attributeService->create($request, $this->language)){
            return redirect()->route('attribute.index')->with('success','Thêm mới bản ghi thành công');
        }
        return redirect()->route('attribute.index')->with('error','Thêm mới bản ghi không thành công. Hãy thử lại');
    }

}
