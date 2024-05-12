<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;

use Illuminate\Support\Facades\Auth;

use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\FeatureExtraction\TokenCountVectorizer; // Tambahkan impor untuk kelas-kelas dari Php-ML
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
        $productId = $id; // Ambil produk_id dari request
        $selectedProduct = Product::with('galleries', 'user')->where('slug', $productId)
            ->firstOrFail();

        // Retrieve all product descriptions
        $productDescriptions = Product::pluck('description')->toArray();
        // $productDescriptions = Product::where('id', '!=', $selectedProduct->id)->pluck('description')->toArray();

        // Calculate TF-IDF
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($productDescriptions);
        $vectorizer->transform($productDescriptions);

        $tfIdfTransformer = new TfIdfTransformer();
        $tfIdfTransformer->fit($productDescriptions);
        $tfIdfTransformer->transform($productDescriptions);

        // Simpan hasil transformasi ke dalam variabel $tfIdfMatrix
        $tfIdfMatrix = $productDescriptions; // Pastikan ini adalah hasil transformasi yang benar

        $cosineMatrix = [];
        foreach ($tfIdfMatrix as $index => $vector) {
            // if ($index == $selectedProduct->id) {
            //     continue;
            // }
            // Pastikan $tempTransformedDesc adalah array dari array
            $tempTransformedDesc = [$selectedProduct->description];
            $vectorizer->transform($tempTransformedDesc); // Pastikan ini di-transform terlebih dahulu jika perlu
            $tfIdfTransformer->transform($tempTransformedDesc);
            $cosineMatrix[$index + 1] = $this->cosineSimilarity($vector, $tempTransformedDesc[0]);
        }

        // // Sort cosine similarity matrix by similarity value (descending order)
        arsort($cosineMatrix);

        // Get top 5 recommended products
        $recommendedProductIds = array_keys(array_slice($cosineMatrix, 0, 10, true));
        // $productRecommendation = Product::with('galleries', 'user')->whereIn('id', $recommendedProductIds)->get();
        $productRecommendation = Product::with('galleries', 'user')->whereIn('id', $recommendedProductIds)->orderByRaw('FIELD(id, ' . implode(',', $recommendedProductIds) . ')')->get();


        //
        $product = Product::with(['galleries', 'user'])
            ->where('slug', $id)
            ->firstOrFail();

        return view('pages.detail', [
            // dd($recommendedProductIds, $productRecommendation, $cosineMatrix)
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
