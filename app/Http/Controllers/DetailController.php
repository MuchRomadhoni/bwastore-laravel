<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

use Illuminate\Support\Facades\Auth;
use Phpml\FeatureExtraction\StopWords;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\FeatureExtraction\TfIdfTransformer;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        // Retrieve the selected product
        $productId = $id;
        $selectedProduct = Product::with('galleries', 'user')->where('slug', $productId)->firstOrFail();

        // Retrieve all product descriptions
        $productDescriptions = Product::pluck('description')->toArray();
        // dd($productDescriptions);

        // Text Preprocessing: Case Folding, Stop Word Removal, and Tokenization
        $stopWords = StopWords::factory('Indonesia');
        foreach ($productDescriptions as &$description) {

            // CASE FOLDING: Lowercase the description
            $description = strtolower($description);

            // REMOVAL: Remove special characters
            $description = preg_replace('/[^\w\s]/', '', $description);

            // Tokenize the description
            $tokens = explode(' ', $description);

            // STOP WORD REMOVAL: Remove stop words
            $tokens = array_filter($tokens, function ($token) use ($stopWords) {
                return !$stopWords->isStopWord($token) && strlen($token) > 1;
            });

            // Reconstruct the description without stop words
            $description = implode(' ', $tokens);
        }
        unset($description);
        // dd($productDescriptions); //tokenized

        // Calculate TF-IDF
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($productDescriptions);
        $vectorizer->transform($productDescriptions);

        $tfIdfTransformer = new TfIdfTransformer();
        $tfIdfTransformer->fit($productDescriptions);
        $tfIdfTransformer->transform($productDescriptions);
        // dd($vectorizer, $tfIdfTransformer); //idf

        $tfIdfMatrix = $productDescriptions;

        // dd($tfIdfMatrix);

        $data = $tfIdfMatrix[$selectedProduct->id - 1];
        $cosineMatrix = [];
        foreach ($tfIdfMatrix as $index => $vector) {
            $cosineMatrix[$index + 1] = $this->cosineSimilarity($vector, $data);
        }
        arsort($cosineMatrix);
        // dd($cosineMatrix);

        // Get top 5 recommended products
        $recommendedProductIds = array_keys(array_slice($cosineMatrix, 0, 6, true));
        $productRecommendation = Product::with('galleries', 'user')->whereIn('id', $recommendedProductIds)->orderByRaw('FIELD(id, ' . implode(',', $recommendedProductIds) . ')')->get();

        // dd($recommendedProductIds, $productRecommendation->toArray(), $cosineMatrix);

        $product = Product::with(['galleries', 'user'])
            ->where('slug', $id)
            ->firstOrFail();

        return view('pages.detail', [
            'product' => $product,
            'productRecommendation' => $productRecommendation
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = [
            'products_id' => $id,
            'users_id' => Auth::user()->id,
        ];

        Cart::create($data);

        return redirect()->route('cart');
    }
    function cosineSimilarity(array $vec1, array $vec2)
    {
        $dotProduct = array_sum(array_map(function ($x, $y) {
            return $x * $y;
        }, $vec1, $vec2));
        $normVec1 = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $vec1)));
        $normVec2 = sqrt(array_sum(array_map(function ($x) {
            return $x * $x;
        }, $vec2)));

        return $dotProduct / ($normVec1 * $normVec2);
    }
}
