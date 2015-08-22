<!DOCTYPE html>
<html lang="en-US">
<head>
  <link rel="stylesheet" href="Style.css">
  <meta charset="UTF-8">
  <title>Testing</title>
</head>
<body>

<main>
<?php
require("WebSyntaxHighlighter.php");

$code = <<<code
/*
* source is the source data already inflated (decompressed)
* startingWidth is the horizontal pixel number (1-based indexing) the pass starts at. Pass 1 = 1, Pass 2 = 5, Pass 3 = 1, Pass 4 = 3
* strideWidth is the number of pixels horizontally until the next pixel. Pass 1 = 8, Pass 2 = 8, Pass 3 = 4, Pass 4 = 4
* startingSL is the vertical pixel number (1-based) the pass starts at. Pass 1 = 1, Pass 2 = 1, Pass 3 = 5, Pass 4 = 1
* strideSL is the number of pixels vertically until the next pixel in the pass. Pass 1 = 8, Pass 2 = 8, Pass 3 = 8, Pass 4 = 4
*/


byte[] undoInterlaceStepFilter(PNGImage image, byteArrayInputStream source, int startingWidth, int strideWidth, int startingSL, int strideSL)
{
    String text = "This class is in quotes, so int is not text."; //comment
    int lengthSL = (image.width + strideWidth - startingWidth) / strideWidth; // Calculate length of scanlines for this pass.
    int numSLs = (image.height + strideSL - startingSL) / strideSL; // Calculate how many scanlines are in this pass.
    byte[] output = new byte[image.getBytesPerPixel() * lengthSL * numSLs];
    byte[] SLP = new byte[lengthSL]; // Scanline Previous
    byte[] SLC = new byte[lengthSL]; // Scanline Current
    for (int i = 0; i &lt; numSLs; ++i)
    {
        byte filterType = (byte) source.read();
        source.read(SLC, (i * lengthSL), lengthSL); // read a full Scan-line's worth into SLC
        unfilter(filterType, SLP, SLC);
        if (i != 0) // SLP is not the beginning array... We don't want to return a scan-line's worth of 0s that's not apart of the picture.
        {
            arraycopy(SLP, 0, output, (i * lengthSL), SLP.length);
        }
        arraycopy(SLC, 0, SLP, 0, SLC.length);
    }
    String text = "This string int" + 15 + " is made up of " + byte + " 3 parts!";
    return output;
}
code;
printJavaCodeBlock($code);
?>

</main>

</body>
</html>
