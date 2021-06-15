<style>
.container{
   display: flex;
   height : 100vh;

   gap: 15px;
   place-content : center center;
   flex-wrap: wrap;
}

[class ^="box-"]{
    width: 140px;
    height: 140px;
    background-color: skyblue;
    border: 2px solid black;
    font-size: 65px;

	display: flex;
	justify-content: center;
	align-items: center;
}

</style>
<div class="container">
    <div class="box-1"> A </div>
    <div class="box-2"> B </div>
    <div class="box-3"> C </div>
</div>