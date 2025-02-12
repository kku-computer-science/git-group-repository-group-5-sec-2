*** Settings ***
Documentation     This is a test suite for valid editing a highlight
Resource          resource.robot

*** Variables ***
${USERNAME}          staff@gmail.com
${PASSWORD}          123456789
${TITLE}             บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ
${DESCRIPTION}       วิทยาลัยการคอมพิวเตอร์ มหาวิทยาลัยขอนแก่น ขอแสดงความยินดีกับ ศ. ดร.จักรชัย โสอินทร์ อ. ดร.ญานิกา คงโสรส อ. ดร.เพชร อิ่มทองคำ และ Mr.Chenset Kim เนื่องในโอกาสที่บทความวิจัยได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ จำนวน 1 บทความวิจัย
${PICTURE_PATH}      ${CURDIR}\\highlight2.png
${RESEARCHER_ID}     3
${PAPER_INDEX}       1    # index of the paper to be selected
${IS_SELECTED}       1    # 1 for display highlight at the home page
${row}               4    # row number of the highlight to be edit

*** Test Cases ***
Login
    Open Browser To Login Page
    Input Username    ${USERNAME}
    Input Password    ${PASSWORD}
    Submit Credentials

Edit Highlight
    Go To Highlight Setting Page
    Click Edit Highlight Button
    Title Should Be    Edit Highlight Paper
    Edit Highlight Form
    Sleep    3s
    [Teardown]    Close Browser

*** Keywords ***
Click Edit Highlight Button
    Scroll Element Into View    xpath=//tbody/tr[${row}]//a[@class='btn btn-warning btn-sm']
    Click Link         xpath=//tbody/tr[${row}]//a[@class='btn btn-warning btn-sm']    # click the edit button of the highlight for the row we want to edit
    Title Should Be    Edit Highlight Paper

Edit Highlight Form
    Input Text    xpath=//input[@name='title']             ${TITLE}
    Input Text    xpath=//input[@name='description']    ${DESCRIPTION}
    Choose File   xpath=//input[@name='picture']           ${PICTURE_PATH}
    Select From List By Value    xpath=//select[@id='researcherSelect']    ${RESEARCHER_ID}
    Select From List By Index    xpath=//select[@id='paperSelect']    ${PAPER_INDEX}    # select the first paper
    Scroll Element Into View     xpath=//button[@class='btn btn-primary']
    Select From List By Value    xpath=//select[@name='isSelected']    ${IS_SELECTED}      # click for display highlight at the home page
    Click Button                 xpath=//button[@class='btn btn-primary']    # click the create highlight button
    Click Button                 xpath=//button[@id='confirmEditBtn']      # confirm the creation of the highlight
    Title Should Be    Highlight Papers