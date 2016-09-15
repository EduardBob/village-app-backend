<?php
namespace Modules\Village\Packback\Transformer;

use Modules\Village\Entities\Document;
use Tymon\JWTAuth\Facades\JWTAuth;

class DocumentTransformer extends BaseTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = ['category'];

    /**
     * List of resources to automatically include
     *
     * @var  array
     */
    protected $defaultIncludes = ['category'];


    /**
     * @return User
     */
    protected function user()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    /**
     * Turn document object into generic array
     *
     * @param Document $document
     *
     * @return array
     */
    public function transform(Document $document)
    {
        $document = $this->personalizeDocument($document);

        return [
          'id'           => $document->id,
          'title'        => $document->title,
          'short'        => str_replace(array("\r\n", "\r", "\n"), "<br />", strip_tags($document->short)),
          'text'         => $document->text,
          'created_at'   => $document->created_at->format('Y-m-d H:i:s'),
          'published_at' => $document->published_at->format('Y-m-d H:i:s'),
          'file'         => $this->getFile($document->files()->first()),
          'is_personal'  => $document->is_personal
        ];
    }

    /**
     * Personalize document if needed.
     *
     * @param Document $document
     *
     * @return Document
     */
    private function personalizeDocument(Document $document)
    {
        $user = $this->user()->load('building');
        if ($document->is_personal && strpos($document->text, '##') !== false) {
            $templates            = ['##first_name##', '##last_name##'];
            $personalReplacements = [$user->first_name, $user->last_name];
            $document->text       = str_replace($templates, $personalReplacements, $document->text);
            $document->short      = str_replace($templates, $personalReplacements, $document->short);
        }
        return $document;
    }

    /**
     * Include DocumentCategory
     *
     * @param Document $document
     *
     * @return Item
     */
    public function includeCategory(Document $document)
    {
        if ($document->category) {
            return $this->item($document->category, new DocumentCategoryTransformer);
        }
        return;
    }
}
