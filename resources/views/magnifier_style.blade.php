<style>
.magnify {
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    display: inline-block;
}
.magnify .magnified {
    display: block;
    z-index: 10;
    margin: auto;
    width: 600px;
    height: 360px;
    border: 5px solid #fff;
}
.magnify .magnifier {
    height: 150px;
    width: 150px;
    position: absolute;
    z-index: 20;
    border: 4px solid white;
    background-size: 1000%;
    background-repeat: no-repeat;
    margin-left: -100px !important;
    margin-top: -100px !important;
    pointer-events: none;
}
img{
    width: 100%;
    height:100%;
}
</style>