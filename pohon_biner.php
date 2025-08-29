<?php
// Definition for a binary tree node.
class TreeNode {
    public $val = null;
    public $left = null;
    public $right = null;

    function __construct($value) {
        $this->val = $value;
    }
}

class Codec {
    function __construct() {
        // Bisa dipakai untuk inisialisasi jika perlu
    }

    /**
     * Serialize: Mengubah pohon biner menjadi string.
     * Format: level order traversal (BFS), null dicatat eksplisit.
     * Contoh: "1,2,3,null,null,4,5"
     */
    function serialize($root) {
        if ($root === null) return "";

        $queue = [$root];
        $result = [];

        while (!empty($queue)) {
            $node = array_shift($queue);
            if ($node === null) {
                $result[] = "null";
            } else {
                $result[] = (string)$node->val;
                $queue[] = $node->left;
                $queue[] = $node->right;
            }
        }

        // hapus "null" berlebih di belakang
        while (!empty($result) && end($result) === "null") {
            array_pop($result);
        }

        return implode(",", $result);
    }

    /**
     * Deserialize: Mengubah string kembali ke pohon biner.
     * Input contoh: "1,2,3,null,null,4,5"
     */
    function deserialize($data) {
        if (empty($data)) return null;

        $nodes = explode(",", $data);
        $root = new TreeNode(intval($nodes[0]));
        $queue = [$root];
        $i = 1;

        while (!empty($queue) && $i < count($nodes)) {
            $current = array_shift($queue);

            // Kiri
            if ($nodes[$i] !== "null") {
                $current->left = new TreeNode(intval($nodes[$i]));
                $queue[] = $current->left;
            }
            $i++;

            // Kanan
            if ($i < count($nodes) && $nodes[$i] !== "null") {
                $current->right = new TreeNode(intval($nodes[$i]));
                $queue[] = $current->right;
            }
            $i++;
        }

        return $root;
    }
}

// --- CONTOH PEMANGGILAN ---
$root = new TreeNode(1);
$root->left = new TreeNode(2);
$root->right = new TreeNode(3);
$root->right->left = new TreeNode(4);
$root->right->right = new TreeNode(5);

$ser = new Codec();
$data = $ser->serialize($root);
echo "Serialized: " . $data . "\n"; // Output: "1,2,3,null,null,4,5"

$deser = new Codec();
$ans = $deser->deserialize($data);
echo "Deserialize Root: " . $ans->val . "\n";      // 1
echo "Left Child: " . $ans->left->val . "\n";      // 2
echo "Right Child: " . $ans->right->val . "\n";    // 3
echo "Right->Left: " . $ans->right->left->val . "\n"; // 4
echo "Right->Right: " . $ans->right->right->val . "\n"; // 5
