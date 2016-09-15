<?php

namespace Modules\Village\Http\Controllers\Api\V1;

use EllipseSynergie\ApiResponse\Contracts\Response;
use Modules\Village\Entities\Document;
use Modules\Village\Packback\Transformer\DocumentTransformer;
use Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends ApiController
{

    /**
     * Get all articles
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $user = $this->user()->load('building');
        $userRoles = $user->roles()->select('id')->lists('id');
        $personalDocuments = $user->documents()->select('document_id')->lists('document_id')->toArray();
        $personalAllDocuments = $users = DB::table('village__document_user')->groupBy('document_id')->lists('document_id');
        $categoryId = (int) $request::query('category_id');

        $documents = Document::api();
        $documents->where('published_at', '<=', date('Y-m-d H:i:s'));
        $documents->where('is_personal', '=', 0);
        $documents->where('active', '=', 1);
        if ($categoryId) {
            $documents
              ->where('category_id', '=', $categoryId)
              ->orWhere(function ($query) use ($categoryId) {
                  $query->whereNull('village_id')
                        ->where('category_id', '=', (int)$categoryId)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              })
              // Getting personal items by user role, item should not be assigned to any user.
              ->orWhere(function ($query) use ($categoryId, $userRoles, $personalAllDocuments) {
                  $query->where('is_personal', '=', 1)
                        ->where('category_id', '=', (int)$categoryId)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'))
                        ->whereNotIn('id', $personalAllDocuments)
                        ->whereIn('role_id', $userRoles);
              })
              // Getting personal items by user relation.
              ->orWhere(function ($query) use ($personalDocuments, $categoryId) {
                  $query->whereIn('id', $personalDocuments)
                        ->where('category_id', '=', (int)$categoryId)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              });

        } else {
            $documents
              ->orWhere(function ($query) {
                  $query->whereNull('village_id')
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              })
              ->orWhere(function ($query) use ($userRoles, $personalAllDocuments) {
                  $query->where('is_personal', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'))
                        ->where('active', '=', 1)
                        ->whereNotIn('id', $personalAllDocuments)
                        ->whereIn('role_id', $userRoles);
              })
              ->orWhere(function ($query) use ($personalDocuments) {
                  $query->whereIn('id', $personalDocuments)
                        ->where('active', '=', 1)
                        ->where('published_at', '<=', date('Y-m-d H:i:s'));
              });
        }

        $documents = $documents->orderBy('published_at', 'desc')->paginate(10);
        return $this->response->withCollection($documents, new DocumentTransformer);
    }

    /**
     * Get a single Document
     *
     * @param int $articleId
     *
     * @return Response
     */
    public function show($documentId)
    {
        $document = Document::api();
        $document->where('id', $documentId);
        $document->orWhere(function ($query) use ($documentId) {
            $query->where('id', $documentId)
                  ->whereNull('village_id');
        });
        $document = $document->first();
        if (!$document) {
            return $this->response->errorNotFound('Not Found');
        }
        return $this->response->withItem($document, new DocumentTransformer);
    }
}
