
<script>
    const toUpperFirst = (str)=>{
        let firstLetter = str.charAt(0);
        let capFirstLetter = firstLetter.toUpperCase();
        let restOfString = str.slice(1);
        let result = capFirstLetter + restOfString;

        return result;
    }

    const toLowerFirst = (str)=>{
        let firstLetter = str.charAt(0);
        let lowerFirstLetter = firstLetter.toLowerCase();
        let restOfString = str.slice(1);
        let result = lowerFirstLetter + restOfString;

        return result;
    }

    const truncateText = (text, wordLimit)=>
    {
        const word = text.split(' ');
        const truncatedWords = word.slice(0, wordLimit);
        const truncatedText = truncatedWords.join(' ');

        if (word.length > wordLimit) 
        {
            return truncatedText + '...';
        } 
        else 
        {
            return truncatedText;
        }
    }

    
   
export { toUpperFirst, toLowerFirst, truncateText };
</script>