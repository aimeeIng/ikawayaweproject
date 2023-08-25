<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiseaseRequest extends FormRequest
{
      /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return false;
        return true;
    }
 
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if(request()->isMethod('post')) {
            return [
                'disease_name' => 'required|string|max:258',
                'category' => 'required|string',
                //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string'
            ];
        } else {
            return [
                'disease_name' => 'required|string|max:258',
                'category' => 'required|string',
                //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string'
            ];
        }
    }
 
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                'disease_name.required' => 'Name is required!',
                'category.required' => 'Category is required!',
                //'image.required' => 'Image is required!',
                'description.required' => 'Descritpion is required!'
            ];
        } else {
            return [
                'disease_name.required' => 'Disease_name is required!',
                'category.required' => 'Category is required!',
                'description.required' => 'Descritpion is required!'
            ];   
        }
    }
}