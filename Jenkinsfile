node {
   // Mark the code checkout 'stage'....
   //stage 'Checkout'

   def bob = tool 'N4'

   stage 'Build'
   
   sh "${bob}/bin/node -v"
   
   sh "${bob}/bin/npm install express"
}
